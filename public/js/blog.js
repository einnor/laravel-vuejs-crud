Vue.http.headers.common['X-CSRF-TOKEN'] = $('#token').attr('value');

new Vue({

    el: '#manage-vue',
    data: {
        items: [],
        pagination: {
            total : 0,
            per_page : 2,
            current_page : 1,
            last_page : 1,
            from : 1,
            to : 0
        },
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {
            'title': '',
            'description': ''
        },
        fillItem: {
            'title': '',
            'description': '',
            'id': ''
        }
    },

    computed: {
        isActivated: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if(!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if(to >+ this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while(from <= to) {
                pagesArray.push(from);
                from++;
            }

            return pagesArray;
        }
    },

    mounted: function() {
        this.getVueItems(this.pagination.current_page);
    },
    methods: {
        getVueItems: function(page) {
            this.$http.get('/blogs?page=' + page)
                .then((response) => {
                    this.$set(this, 'items', response.data.data.data);
                    this.$set(this, 'pagination', response.data.pagination);
                });
        },

        createItem: function() {
            var input = this.newItem;
            this.$http.post('/blogs', input)
                .then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'title': '',
                        'description': ''
                    };
                    $('#create-modal').modal('hide');
                    toastr.success('Post created successfully.', 'Success Alert', {timeOut: 5000});
                }, (response) => {
                    this.formErrors = response.data;
                });
        },

        deleteItem: function(item) {
            this.$http.delete('/blogs/' + item.id)
                .then((response) => {
                    this.changePage(this.pagination.current_page);
                    toastr.success('Post deleted successfully.', 'Success Alert', {timeOut: 5000});
                });
        },

        editItem: function(item) {
            this.fillItem.title = item.title;
            this.fillItem.description = item.description;
            this.fillItem.id = item.id
            $('#edit-modal').modal('show');
        },

        updateItem: function(item) {
            var input = this.fillItem;
            this.$http.put('/blogs/' + item.id, input)
                .then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'title': '',
                        'description': ''
                    };
                    $('#edit-modal').modal('hide');
                    toastr.success('Post updated successfully.', 'Success Alert', {timeOut: 5000});
                }, (response) => {
                    this.formErrorsUpdate = response.data;
                });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
    }

});