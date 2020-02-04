class Validator {
    /**
     * Checking Types
     */
    email = ({value}) => /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/.test(value);
    business = ({value}) => /^[0-9]{3}-[0-9]{2}-[0-9]{5}$/.test(value);
    phone = ({value}) => /^[0-9]{3}-[0-9]{4}-[0-9]{4}$/.test(value);
    number = ({value}) => /^[0-9]+$/.test(value);
    image = ({files}) => new Promise(res => {
        if(!files || !files[0]) res(false);
        else {
            // 이미지가 로딩에 성공하면 올바른 이미지라고 판단
            let img = document.createElement("img");
            img.src = URL.createObjectURL(files[0]);

            img.onload = () => res(true);
            img.onerror = () => res(false);
        }
    });

    /**
     * Initial
     */

    constructor({form, inputs = [], rules = {}, errors = {}, final = () => true}){
        this.$form = typeof form === "string" ? document.querySelector(form) : form;
        this.inputs = inputs.map(x => typeof x === "string" ? document.querySelector(x) : x);
        this.$rules = rules;
        this.errors = errors;
        this.final = final;
    }

    /**
     * Check Start
     */

    start(){
        this.$form.addEventListener("submit", async e => {
            e.preventDefault();

            let result = true;
            for(let $input of this.inputs){
                const {value, name} = $input;
                const rule = this.$rules[name];
                
                let emptyCheck = rule === "image" ? true : value.trim().length > 0; // 값이 비어있는지 체크
                let typeCheck = true;                                               // 타입이 일치하는지 체크
                if(this[rule]) typeCheck = await this[rule]($input);
                

                if(typeCheck && emptyCheck) error($input);
                else error($input, this.errors[name]);
            

                result &= (typeCheck && emptyCheck);
            }

            result &= this.final();

            if(result) this.$form.submit();
        }); 
    }
}