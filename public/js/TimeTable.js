class TimeTable {
    constructor(target){
        // image to change
        this.$image = typeof target === "string" ? document.querySelector(target) : target;
    
        //canvas
        this.$canvas = document.createElement("canvas");
        this.$canvas.width = this.width = this.$image.offsetWidth;
        this.ctx = this.$canvas.getContext("2d");
        this.ctx.lineJoin = this.ctx.lineCap = "round";
    }

    set font(value){
        this.ctx.font = `bold ${parseInt(value)}px 나눔스퀘어, sans-serif`;
    }

    loadData(){
        return new Promise(res => jQuery.post("/admin/timetable-list", data => res(data)));
    }

    update(){
        // option
        const title_font = 17;
        const sub_font = 12;
        const boxHeight = 100;
        const px = 40;
        const py = 20;
        const text_gab = 30;
        const LINE_HEIGHT = py * 2 + boxHeight + title_font + sub_font + text_gab;

        this.loadData().then(schedule => {
            // 영화관 가져오기
            let cinemaList = [];
            schedule.forEach(item => {
                !cinemaList.includes(item.cinema_name) && cinemaList.push(item.cinema_name);
            })

            // 영화관 재구성
            this.$canvas.height = LINE_HEIGHT * cinemaList.length;
            cinemaList = cinemaList.map((name, i) => ({
                name: name,
                X: px,
                startY: LINE_HEIGHT * i,
                boxY: LINE_HEIGHT * i + title_font + sub_font + text_gab,
                boxW: (this.width - px * 2),
                boxH: boxHeight,
                title_font,
                sub_font,
                text_gab
            }));
            
            // 시간표 작성
            this.drawSchedule({cinemaList, schedule});
            this.drawOutline(cinemaList);

            // 원래 이미지와 바꿔치기
            this.$image.src = this.$canvas.toDataURL("image/png");
        });
    }

    drawOutline(cinemaList){       
        let {ctx} = this;

        cinemaList.forEach(cinema => {

            // 영화관 명
            ctx.strokeStyle = ctx.fillStyle = "#505050";
            this.font = cinema.title_font;
            ctx.fillText(cinema.name, cinema.X, cinema.startY + cinema.title_font);

            // 시간 표기
            ctx.fillStyle = "#808080";
            this.font = cinema.sub_font;

            const unit_x = cinema.boxW / 18;
            const Y = cinema.startY + cinema.title_font + cinema.sub_font + cinema.text_gab / 2;
            for(let i = 0; i <= 18; i++){
                let X = cinema.X + unit_x * i + 5;
                ctx.fillText(i + 8, X, Y);

                if(i > 0){
                    ctx.beginPath();
                    ctx.moveTo(X - 5, Y - cinema.sub_font);
                    ctx.lineTo(X - 5, Y + cinema.sub_font / 2);
                    ctx.stroke();
                }
            }

            // 박스 표기
            ctx.strokeRect(cinema.X, cinema.boxY, cinema.boxW, cinema.boxH);

            cinemaList.push(cinema)
        });
    }   

    drawSchedule({cinemaList, schedule}){
        cinemaList.forEach(cinema => {
            let showList = schedule.filter(item => item.cinema_name === cinema.name);
            showList.forEach(item => {
                let startX = cinema.X + (item.start_time - 480) * cinema.boxW / 1080;
                let endX = cinema.X + (item.end_time - 480) * cinema.boxW / 1080;
                let width = endX - startX;

                this.ctx.fillStyle = "#e0e0e0";
                this.ctx.fillRect(startX, cinema.boxY, width, cinema.boxH);

                this.ctx.fillStyle = "#505050";
                this.font = cinema.sub_font;
                let measure = this.ctx.measureText(item.movie_name);
                let textX = startX + width / 2 - measure.width / 2;
                let textY = cinema.boxY + cinema.boxH / 2 + cinema.sub_font / 2;
                this.ctx.fillText(item.movie_name, textX, textY);
            });
        });
    }
}