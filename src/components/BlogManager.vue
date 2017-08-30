<style scoped>
h1{
    font-size: 30px;
    font-weight: 300;
    margin: 0 0 5px 0;
}
.subtitle{
    font-size: 16px;
    font-weight: 300;
    font-style: italic;
    margin: 0 0 15px 0;   
}
.search-bar, .btn-back{
    margin: 15px 0;
}    
</style>

<template>

    <div>

        <div class="row">
            <div class="col-md-3">
                
                <h1>Blog manager</h1>

                <div class="subtitle">
                    <span v-if="loaded && pagination.total > 0">
                        {{ (pagination.current_page - 1) * pagination.per_page + 1 }}
                        à {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} sur {{ pagination.total }}
                    </span>
                    <span v-else-if="loaded && pagination.total == 0">
                        No result
                    </span>
                    <span v-else>
                        Loading...
                    </span>
                </div>

                <button type="button" class="btn btn-primary btn-block" @click="openCreate">
                    <i class="fa fa-plus"></i> New article...
                </button>

                <div class="search-bar">
                    <input-text
                        v-model="search.text"
                        name="search"
                        placeholder="Search..."
                        :autofocus="true">
                    </input-text>
                </div>

            </div>

            <div class="col-md-9">

                

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                pagination: {},
                page: 1,
                search: {
                    text: '',
                },

                readStatus: false,

                createItem: {
                    title: null
                },
                createErrors: null,
                createStatus: null,

                updateItem: {},
                updateErrors: null,
                updateStatus: null,

                destroyItem: {},
                destroyError: null,
                destroyStatus: null,
            };
        },

        mounted() {
            this.read();
        },

        methods: {

            read() {
                
                this.store.commit('setStatus', {
                    status: 'pending', 
                    message: 'Chargement des sociétés de gestion...'
                });

                var url = '/admin/api/societe?page=' + this.page;
                url += '&text=' + this.search.text;
                
                axios.get(url).then(response => {
                    
                    this.pagination = response.data;
                    this.loaded = true;

                    this.store.commit('setStatus', {
                        status: 'success', 
                        message: 'Sociétés de gestion chargées avec succès !'
                    });

                }).catch(response => {
                    
                    this.store.commit('setStatus', {
                        status: 'error', 
                        message: response.response.data
                    });

                });
            },

            openCreate(){
                this.createItem.name = null;
                this.createErrors = null;
                this.createStatus = null;

                $(this.$el).find('.modal-create').modal('show');
            },

            create(){

                var item = this.$refs.formSocieteCreate.item;
                
                this.store.commit('setStatus', {
                    status: 'pending', 
                    message: 'Création de la société de gestion...'
                });

                this.createStatus = 'loading';
                
                axios.post('/admin/api/societe', item).then(response => {

                    this.createStatus = 'success';

                    $(this.$el).find('.modal-create').modal('hide');

                    this.read();

                    this.store.commit('setStatus', {
                        status: 'success', 
                        message: 'Société de gestion créée avec succès !'
                    });

                }).catch(response => {
                    
                    this.createStatus = 'error';
                    this.createErrors = response.response.data;

                    this.store.commit('setStatus', {
                        status: 'error', 
                        message: response.response.data
                    });

                });
            },

            openUpdate(item){
                this.updateItem = item;
                this.updateErrors = null;
                this.updateStatus = null;

                $(this.$el).find('.modal-update').modal('show');
            },

            update(){

                var item = this.$refs.formSocieteUpdate.item;
                
                this.store.commit('setStatus', {
                    status: 'pending', 
                    message: 'Enregistrement de la société de gestion...'
                });

                this.updateStatus = 'loading';
                
                axios.put('/admin/api/societe/' + item.id, item).then(response => {

                    this.updateStatus = 'success';

                    $(this.$el).find('.modal-update').modal('hide');

                    this.read();

                    this.store.commit('setStatus', {
                        status: 'success', 
                        message: 'Société de gestion enregistrée avec succès !'
                    });

                }).catch(response => {
                    
                    this.updateStatus = 'error';
                    this.updateErrors = response.response.data;

                    this.store.commit('setStatus', {
                        status: 'error', 
                        message: response.response.data
                    });

                });
            },

            openDestroy(item){
                
                this.destroyItem = item;
                this.destroyChecker = null;
                this.destroyError = null;
                this.destroyStatus = null;

                $(this.$el).find('.modal-destroy').modal('show');
            },

            destroy() {

                if(this.destroyChecker != this.destroyItem.name){
                    this.destroyError = "Le nom ne correspond pas";
                    return;
                }

                this.store.commit('setStatus', {
                    status: 'pending', 
                    message: 'Suppression le la société de gestion ' + this.destroyItem.id
                });

                this.destroyStatus = 'loading';
                
                axios.delete('/admin/api/societe/' + this.destroyItem.id).then(response => {

                    this.read();

                    this.destroyStatus = 'success';

                    $(this.$el).find('.modal-destroy').modal('hide');

                    this.store.commit('setStatus', {
                        status: 'success', 
                        message: 'Société de gestion supprimée avec succès !'
                    });

                }).catch(response => {

                    this.destroyStatus = 'error';
                    this.destroyError = response.response.data;
                    
                    this.store.commit('setStatus', {
                        status: 'error', 
                        message: response.response.data
                    });

                });

            },

            openScpi(item){
                
                this.createScpiItem.name = null;
                this.createScpiItem.societe_id = item.id;
                this.createScpiStatus = null;
                this.createScpiErrors = null;
                this.scpi = null;

                $(this.$el).find('.modal-create-scpi').modal('show');
            },

            createScpi(){

                this.store.commit('setStatus', {
                    status: 'pending', 
                    message: 'Création de la SCPI...'
                });

                this.createScpiStatus = 'loading';
                
                axios.post('/admin/api/scpi', this.createScpiItem).then(response => {

                    this.createScpiStatus = 'success';
                    this.scpi = response.data.id;
                    this.read();

                    this.store.commit('setStatus', {
                        status: 'success', 
                        message: 'SCPI créée avec succès !'
                    });

                }).catch(response => {
                    
                    this.createScpiStatus = 'error';
                    this.createScpiErrors = response.response.data;

                    this.store.commit('setStatus', {
                        status: 'error', 
                        message: response.response.data
                    });

                });
            },

            loadPage(p){
                this.page = p;
                this.read();
            },
        }
    }
</script>
