let template = `
<div class="uk-section o-crud">
    <div class="uk-container">
        <h3>form builder ({{ forms.length }})</h3>
        <hr>
        <o-form name="form-loader-json"></o-form>
        <hr>
        <div class="informs uk-child-width-1-1" uk-grid uk-sortable>
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>type</th>
                        <th>value</th>
                        <th>remove</th>
                    </tr>
                </thead>
                <tbody uk-sortable>
                    <tr v-for="(input, index) in inputs" :data-i="index">
                        <td><input v-model="input.name" placeholder="name"></td>
                        <td><input v-model="input.type" placeholder="type"></td>
                        <td><input v-model="input.value" placeholder="value"></td>
                        <td><button @click.prevent="act_remove(input)">x</button></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <button @click.prevent="act_add()">add more input</button>
            </div>
        </div>
        <div>
            <textarea v-model="process_response" class="uk-textarea" placeholder="process_response"></textarea>
        </div>
        <div>
            <input v-model="form_name" placeholder="form_name">
            <input v-model="form_c" placeholder="class">
            <input v-model="form_m" placeholder="method">
        </div>
        <div>
            <button @click.prevent="act_form_save">save form</button>
        </div>

        <hr>
        input search: <input v-model="search" placeholder="search">
        <button @click.prevent="show=search">load form</button>
        <div v-if="show">
            <o-form :name="show"></o-form>
        </div>
        <hr>

        <div class="uk-grid">
            <div v-for="form in forms" class="uk-width-1-2">
                <h4>{{ form.title }}</h4>
            </div>
        </div>
    </div>
</div>
`

let commix = await import('/mjs?compo=o-commix');
let mixins = [ commix.default.mixin ]; // warning: must add .default

let data_compo = {
    forms: [],
    inputs : [
        { name: 'title', label: 'Title', type: 'text', value: '' },
        { name: 'name', label: 'Name', type: 'text', value: '' },
        { name: 'description', label: 'Description', type: 'textarea', value: '' },
    ],
    process_response: '',
    form_name: '',
    form_c: 'admin',
    form_m: 'test',
    show: '',
    search: '',
}

let methods = {
    async act_remove (input) {
        console.log('act_remove', input);
        let i = this.inputs.indexOf(input);
        this.inputs.splice(i, 1);
    },
    async act_add () {
        console.log('act_add');
        this.inputs.push({ name: 'info' + (1+this.inputs.length), label: '', type: 'text', value: '' });
    },
    build_form_data () {
        // build form data common to all api calls
        let data = new FormData();
        data.append('k', this.center.api_admin_key);
        data.append('c', 'admin');
        data.append('m', 'form');
        data.append('action', 'create');
        data.append('table', this.table_name);
        return data;
    },
    async act_form_save () {
        // get inputs order
        let informs = document.querySelector('.informs tbody');
        let inputs_save = [];
        for (let tr of informs.children) {
            let i = tr.dataset.i;
            if (i) {
                // console.log('i', i);
                inputs_save.push(this.inputs[i]);    
            }
        }
        console.log('act_form_save', inputs_save);
        let fd = this.build_form_data();
        // add inputs
        for (let input of inputs_save) {
            fd.append('inputs[]', JSON.stringify(input));
        }
        // add api_c and api_m to inputs_save
        fd.append('inputs[]', JSON.stringify({ type: 'hidden', name: 'c', value: this.form_c }));
        fd.append('inputs[]', JSON.stringify({ type: 'hidden', name: 'm', value: this.form_m }));

        // add process_response
        fd.append('process_response', this.process_response);
        // add form_name
        fd.append('form_name', this.form_name);

        // send
        let res = await fetch('/api', {
            method: 'POST',
            body: fd,
        });
        let json = await res.json();
        console.log(json);              
    },
    async load_forms () {
        let res = await fetch('/api');
        let json = await res.json();
        return json.forms ?? [];
    }  
}

let created = async function () {
    console.log('o-admin-form-builder created');
    this.forms = await this.load_forms();
    console.log(this.forms);

    // add event listener on moved
    let informs = document.querySelector('.informs');
    informs.addEventListener('moved', (e) => {
        console.log('moved', e);
    })

}
export default {
    template,
    mixins,
    data: () => JSON.parse(JSON.stringify(data_compo)),
    methods,
    created,
}