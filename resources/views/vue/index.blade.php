@extends('app')

@section('content')

    <div class="form-group row add">
        <div class="col-md-12">
            <h1>Laravel Vue.js Application</h1>
        </div>
        <div class="col-md-12">
            <button type="button" data-toggle="modal" data-target="#create-modal" class="btn btn-primary">Create New Post</button>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <tr v-for="item in items">
                    <td>@{{ item.title }}</td>
                    <td>@{{ item.description }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="edit-modal btn-warning" @click.prevent="editItem(item)">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                            <button type="button" class="delete-modal btn-danger" @click.prevent="deleteItem(item)">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <nav>
        <ul class="pagination">
            <li v-if="pagination.current_page > 1">
                <a href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li v-for="pages in pagesNumber" v-bind:class="[ page == isActivated ? 'active' : '' ]">
                <a href="#" @click.prevent="changePage(page)">@{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Create modal -->
    <div class="modal fade" id="create-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">x</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Blog Post</h4>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" class="form-control" v-model="newItem.title" />
                            <span v-if="formErrors['title']" class="error text-danger">
                                @{{ formErrors['title'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" v-model="newItem.description"></textarea>
                            <span v-if="formErrors['description']" class="error text-danger">
                                @{{ formErrors['description'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit modal -->
    <div class="modal fade" id="edit-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">x</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit Blog Post</h4>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" class="form-control" v-model="fillItem.title" />
                            <span v-if="formErrorsUpdate['title']" class="error text-danger">
                                @{{ formErrorsUpdate['title'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" v-model="fillItem.description"></textarea>
                            <span v-if="formErrorsUpdate['description']" class="error text-danger">
                                @{{ formErrorsUpdate['description'] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop