<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">
                            Alexander Pierce
                        </h3>
                        <h5 class="widget-user-desc">Founder &amp; CEO</h5>
                    </div>
                    <div class="widget-user-image">
                        <img
                            class="img-circle elevation-2"
                            src="img/user.jpg"
                            alt="User Avatar"
                        />
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        3,200
                                    </h5>
                                    <span class="description-text">SALES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        13,000
                                    </h5>
                                    <span class="description-text"
                                        >FOLLOWERS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text"
                                        >PRODUCTS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
        </div>
        <div class="row mt-5 bg-primary">
            <div class="col-md-12 p-3">
                <div class="tab-pane active" id="settings">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label
                                for="inputName"
                                class="col-sm-2 col-form-label"
                                >Name</label
                            >
                            <div class="col-sm-10">
                                <input
                                    v-model="form.name"
                                    type="email"
                                    class="form-control"
                                    id="inputName"
                                    placeholder="Name"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                for="inputEmail"
                                class="col-sm-2 col-form-label"
                                >Email</label
                            >
                            <div class="col-sm-10">
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="form-control"
                                    id="inputEmail"
                                    placeholder="Email"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="inputExperience"
                                class="col-sm-2 col-form-label"
                                >bio</label
                            >
                            <div class="col-sm-10">
                                <textarea
                                    v-model="form.bio"
                                    class="form-control"
                                    id="inputExperience"
                                    placeholder="Experience"
                                ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="inputExperience"
                                class="col-sm-2 col-form-label"
                                >image</label
                            >
                            <div class="col-sm-10">
                                <input
                                    type="file"
                                    @change="updateProfile"
                                    name="photo"
                                    class="form-input"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-success">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: "",
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
        this.getCurrentUser();
    },
    methods: {
        getCurrentUser() {
            axios
                .get("api/profile")
                .then(({ data }) => {
                    console.log(data);
                    this.form.fill(data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateProfile(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = (file) => {
                // console.log("result", reader.result);
                this.form.photo = reader.result;
            };
            reader.readAsDataURL(file);
        }
    }
};
</script>

<style></style>
