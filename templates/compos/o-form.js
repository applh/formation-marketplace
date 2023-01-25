let template =
`
<form @submit.prevent="send" class="uk-form uk-container">
    <h3>{{ f.title }}</h3>
    <div v-for="input in f.inputs">
        <label class="uk-form-label">{{ input.label }}</label>
        <input :name="input.name" :type="input.type" :placeholder="input.placeholder" :required="input.required" v-model="input.value" class="uk-input">
    </div>
    <button type="submit">Submit</button>
    <div>{{ feedback }}</div>
</form>
`
let commix = await import('/mjs?compo=o-commix.js');
let mixins = [commix.default.mixin]; // warning: must add .default


let props = [ 'name' ];

let data_compo = {
    f: {},
    feedback: '',
}
let created = async function () {
    console.log('o-form created', this.name);
    this.f = await this.load_form(this.name);
    console.log(this.f);
    
}

let methods = {
    async send () {
        console.log('o-form send');
        let fd = new FormData();
        for (let input of this.f.inputs) {
            fd.append(input.name, input.value);
        }
        let res = await fetch(this.center.api_url, {
            method: 'POST',
            body: fd,
        });
        let json = await res.json();
        console.log(json);
        this.feedback = json.feedback ?? '';
        if (this.f.process_response) {
            this.f.process_response(json);
        }
    }
}

export default {
    template,
    props,
    mixins,
    created,
    data: () => JSON.parse(JSON.stringify(data_compo)),
    methods,
}