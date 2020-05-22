<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="createUserModal">
                                Add New <i class="fa fa-user-plus fa-fw"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>bio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!users.data">
                                    <img src="img/loding.gif" alt="">
                                </tr>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.type | upText }}</td>
                                    <td>{{ user.created_at | myDate }}</td>
                                    <td>{{ user.bio }}</td>
                                    <td>
                                        <a href="#" @click="editUserModal(user)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        <a
                                            href="#"
                                            @click="deleteUserAlert(user.id)"
                                        >
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- User Modal -->
        <div
            class="modal fade"
            id="usermodal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="userModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="userModalLabel"
                            v-text="
                                editmode ? 'Update new user' : '  Add New User'
                            "
                        ></h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- modal body -->
                    <form
                        @submit.prevent="
                            editmode ? editUser(editUserID) : createUser()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="name"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <input
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="email"
                                    :class="{
                                        'is-invalid': form.errors.has('email')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="email"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <textarea
                                    v-model="form.bio"
                                    type="text"
                                    name="bio"
                                    class="form-control"
                                    placeholder="bio"
                                    :class="{
                                        'is-invalid': form.errors.has('bio')
                                    }"
                                />
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                                <select
                                    v-model="form.type"
                                    type="text"
                                    name="type"
                                    class="form-control"
                                    placeholder="type"
                                    :class="{
                                        'is-invalid': form.errors.has('type')
                                    }"
                                >
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard</option>
                                    <option value="author">author</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="type"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <input
                                    v-model="form.password"
                                    type="text"
                                    name="password"
                                    class="form-control"
                                    :placeholder="passwordMSG"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'password'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="password"
                                ></has-error>
                            </div>
                        </div>
                        <!-- end modal body -->

                        <div class="modal-footer">
                            <button
                                type="submit"
                                class="btn btn-danger"
                                data-dismiss="modal"
                                @click="reset"
                            >
                                Close
                            </button>

                            <button
                                type="submit"
                                :class="editmode ?' btn btn-success':' btn btn-primary'"
                                v-text="editmode ? 'Update' : 'Create'"
                            ></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End User Modal -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: {},
            editmode: null,
            passwordMSG: null,
            editUserID: null,
            form: new Form({
                name: "",
                email: "",
                password: "",
                type: "",
                bio: "",
                photo: ""
            })
        };
    },
    created() { 
        this.loadUsers();
    },
    methods: {
        editUserModal(user) {
            this.editmode = true;
            this.reset();
            $("#usermodal").modal("show");
            this.form.fill(user);
            this.editUserID = user.id;
            this.passwordMSG = "change password optionally :)";
        },
        createUserModal() {
            this.editmode = false;
            this.reset();
            $("#usermodal").modal("show");
            this.passwordMSG = "password";
        },
        reset() {
            this.form.reset();
            this.form.clear();
        },
        createUser() {
            this.$Progress.start();
            this.form
                .post("api/user")
                .then(() => {
                    $("#usermodal").modal("hide");
                    this.loadUsers();
                    this.reset();
                    this.$Progress.finish();
                    this.showUserToast("user is created");
                })
                .catch(() => {
                    this.$Progress.finish();
                });
        },
        editUser(editUserID) {
            this.$Progress.start();
            this.form
                .put(`api/user/${editUserID}`)
                .then(res => {
                    console.log(res);
                    this.loadUsers();
                    $("#usermodal").modal("hide");
                    this.reset();
                    this.$Progress.finish();
                    this.showUserToast("user is edited");
                })
                .catch(error => {
                    console.log(error);
                    this.$Progress.finish();
                });
        },
        loadUsers() {
            axios.get("api/user").then(data => {
                this.users = data.data;
            });
        },
        deleteUser(userID) {
            this.$Progress.start();
            axios
                .delete(`api/user/${userID}`)
                .then(res => {
                    console.log(res);
                    this.loadUsers();
                    this.$Progress.finish();
                })
                .catch(erro => {
                    console.log(erro);
                    this.$Progress.finish();
                });
        },
        showUserToast(text) {
            this.$swal({
                toast: true,
                title: text,
                icon: "success",
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        },
        deleteUserAlert(userID) {
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.value) {
                    this.deleteUser(userID);
                    this.$swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                }
            });
        }
    }
};
</script>

<style>


</style>