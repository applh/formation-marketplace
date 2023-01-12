
console.log('o-crud.js loaded');

let inject = [ 'main_app' ];
let props = [ 'title', 'table' ];

let data_compo = {
    table_name: '',
    feedback: '...',
    items: [],
}

let template = `
<div class="uk-container">
    <h3>{{ title }}</h3>
    <input type="text" v-model="table_name">
    <button @click="load_items">Load items</button>
    <p>{{ feedback }}</p>
    <h4>{{ items.length + ' ' + table_name + '(s)' }}</h4>
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped">
            <tbody>
                <tr v-for="item in items">
                    <td><button @click.prevent="item_delete(item)">Delete</button></td>
                    <td><button>Edit</button></td>
                    <td v-for="col in item">{{ col }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
`;

let methods = {
    async item_delete (item) {
        // delete item from api
        let data = new FormData();
        data.append('k', this.main_app.admin_api_key);
        data.append('c', 'admin');
        data.append('m', 'crud');
        data.append('action', 'delete');
        data.append('table', this.table_name);
        data.append('id', item.id);
        // fetch data from api
        let response = await fetch(this.main_app.api_uri, {
            method: 'POST',
            body: data
        });
        let json = await response.json();
        this.feedback = json.feedback ?? 'xxx';
        this.items = json.items ?? [];
    },
    async load_items () {
        // load items from api
        let data = new FormData();
        data.append('k', this.main_app.admin_api_key);
        data.append('c', 'admin');
        data.append('m', 'crud');
        data.append('table', this.table_name);
        // fetch data from api
        let response = await fetch(this.main_app.api_uri, {
            method: 'POST',
            body: data
        });
        let json = await response.json();
        this.feedback = json.feedback ?? 'xxx';
        this.items = json.items ?? [];
    }
}

let created = async function () {
    this.main_app.test('o-crud created');
    // prop table is read only
    this.table_name = this.table;

}

let mounted = function () {
    this.main_app.test('o-crud mounted');
}

// vue js async component
export default {
    template,
    inject,
    props,
    // hack: copy to avoid sharing data between instances
    data: () => {return {...data_compo}},
    // mixins,
    // setup,
    methods,
    created,
    mounted,
}