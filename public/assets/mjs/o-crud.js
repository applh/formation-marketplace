
console.log('o-crud.js loaded');

import { default as commix } from '/assets/js/o-commix.js';
let mixins = [ commix.mixin ];

let inject = [ 'main_app' ];
let props = [ 'title', 'table' ];

let data_compo = {
    options_default: {
        show_panel: true,
        show_list: true,
        show_create: false,
        show_update: false,
    },
    table_name: '',
    feedback: '...',
}

let template = `
<div class="uk-container o-crud">
    <h3 class="uk-grid" uk-grid>
        <span class="uk-width-expand">{{ title }}</span>
        <label><input class="uk-checkbox" type="checkbox" v-model="options.show_panel"></label>
    </h3>

    <div class="uk-margin" v-show="options.show_panel">
        <div class="uk-flex-inline">
            <input class="uk-input" type="text" v-model="table_name">
            <button class="uk-button uk-button-small uk-button-primary" @click="load_items">Load</button>
        </div>
        <p>{{ feedback }}</p>

        <div uk-grid class="uk-child-width-expand">
            <div>
                <h4>
                Add {{ table_name }}
                <label><input class="uk-checkbox" type="checkbox" v-model="options.show_create"></label>
                </h4>
                <div class="" v-if="options.show_create">
                    <form @submit.prevent="item_add($event)">
                        <div class="uk-margin" v-for="field in form_create">
                            <textarea v-if="field.type=='textarea'" class="uk-textarea" rows="10" :name="field.name" :placeholder="field.label" :aria-label="field.label" v-model="field.val"></textarea>
                            <input v-else-if="field.type=='file'" :type="field.type" :placeholder="field.label" @change="updateFile(field, $event)">
                            <input v-else class="uk-input" :type="field.type" :name="field.name" :placeholder="field.label" :aria-label="field.label" v-model="field.val">
                        </div>
                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-default">add {{ table_name }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <h4>
                Update {{ table_name }}
                <label><input class="uk-checkbox" type="checkbox" v-model="options.show_update"></label>
                </h4>
                <div class="" v-if="options.show_update">
                    <form @submit.prevent="item_update($event)">
                        <div class="uk-margin" v-for="field in form_update">
                            <textarea v-if="field.type=='textarea'" class="uk-textarea" rows="10" :name="field.name" :placeholder="field.label" :aria-label="field.label" v-model="field.val"></textarea>
                            <input v-else class="uk-input" :type="field.type" :name="field.name" :placeholder="field.label" :aria-label="field.label" v-model="field.val">
                        </div>
                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-default">update {{ table_name }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>   

        <h4>
        {{ items?.length + ' ' + table_name + '(s)' }}
        <label><input class="uk-checkbox" type="checkbox" v-model="options.show_list"></label>
        </h4>
        <div class="uk-overflow-auto" v-if="options.show_list">
            <table class="uk-table uk-table-striped" v-if="items?.length > 0">
                <thead>
                    <tr>
                        <th>Delete</th>
                        <th>Edit</th>
                        <th v-for="(col, name, index) in items[0]">{{ name }}</td>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items">
                        <td><button class="uk-button uk-button-small uk-button-danger" @click.prevent="item_delete(item)">Delete</button></td>
                        <td><button class="uk-button uk-button-small uk-button-primary" @click.prevent="copy_update_form(item)">Edit</button></td>
                        <td v-for="col in item">
                            <div>{{ col }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>
`;


let computed = {
    items () {
        return this.center.items[this.table_name] ?? [];
    },
    form_create () {
        return this.center.create_forms[this.table_name] ?? [];
    },
    form_update () {
        return this.center.update_forms[this.table_name] ?? [];
    },
    options () {
        // if not set, set default options
        let co = this.center.options;
        if (!co[this.table_name]) {
            co[this.table_name] = this.options_default;
        }
        return co[this.table_name];
    }
}

let methods = {
    updateFile(input, e) {
        input.files = e.target.files || e.dataTransfer.files;
        console.log(input.files);
    },
    build_form_data () {
        // build form data common to all api calls
        let data = new FormData();
        data.append('k', this.center.api_admin_key);
        data.append('c', 'admin');
        data.append('m', 'crud');
        data.append('table', this.table_name);
        return data;
    },
    async send_form_data (data) {
        // fetch data from api
        let response = await fetch(this.main_app.api_uri, {
            method: 'POST',
            body: data
        });
        let json = await response.json();
        this.feedback = json.feedback ?? 'xxx';
        this.center.items[this.table_name] = json.items ?? [];

        // get form_create and form_update from api
        this.center.create_forms[this.table_name] = json.form_create ?? [];
        this.center.update_forms[this.table_name] = json.form_update ?? [];
    },
    copy_update_form (item) {
        console.log('copy_update_form', item);
        // copy item to form_update
        for (let field of this.form_update) {
            console.log(field.name, item[field.name]);
            field.val = item[field.name];
        }
    },
    item_update (event) {
        // update item in api
        let data = this.build_form_data();
        data.append('action', 'update');
        // get form data from event.target
        for (let field of this.form_create) {
            data.append(field.name, event.target[field.name].value);
        }
        this.send_form_data(data);
    },
    async item_add (event) {
        // add item to api
        let data = this.build_form_data();
        data.append('action', 'create');
        // get form data from event.target
        for (let field of this.form_create) {
            if (field.type == 'file') {
                // console.log(field.files);
                if (field.files ?? false) {
                    if (field.files.length > 0) {
                        data.append(field.name, field.files[0]);
                    }
                }
            }
            else
                data.append(field.name, event.target[field.name].value);
        }

        this.send_form_data(data);
    },
    item_delete (item) {
        // delete item from api
        let data = this.build_form_data();
        data.append('action', 'delete');
        data.append('id', item.id);
        this.send_form_data(data);
    },
    load_items () {
        // load items from api
        let data = this.build_form_data();
        data.append('action', 'read');
        this.send_form_data(data);
    }
}

let created = async function () {
    // this.main_app.test('o-crud created');
    // prop table is read only
    this.table_name = this.table;

}

let mounted = function () {
    // this.main_app.test('o-crud mounted');

    // console.log(this.center);
}

// vue js async component
export default {
    template,
    inject,
    props,
    // hack: deep copy to avoid sharing data between instances
    // https://code.tutsplus.com/articles/the-best-way-to-deep-copy-an-object-in-javascript--cms-39655
    data: () => JSON.parse(JSON.stringify(data_compo)),
    mixins,
    computed,
    // setup,
    methods,
    created,
    mounted,
}