<template>
    <div class="content">
        <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4"
             style="background-image: url('images/bg_1.jpg')">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-7">
                        <h2 class="mb-0">Đăng ký khóa học</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="custom-breadcrumns border-bottom">
            <div class="container">
                <a href="#">Trang chủ</a>
                <span class="mx-3 icon-keyboard_arrow_right"></span>
                <span class="current">Đăng ký khóa học</span>
            </div>
        </div>

        <div style="padding: 50px">
            <div class="container">
                <div class="row">
                    <div class="alert alert-success col-md-12" v-if="success !== ''">
                        {{ success }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_name">Họ</label>
                        <input type="text" id="first_name" v-model="form.first_name"
                               class="form-control form-control-md" required>
                        <p v-if="errors.first_name" class="text-danger">{{ errors.first_name[0] }}</p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name">Tên</label>
                        <input type="text" id="last_name" v-model="form.last_name"
                               class="form-control form-control-md required">
                        <p v-if="errors.last_name" class="text-danger">{{ errors.last_name[0] }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" v-model="form.email" class="form-control form-control-md"
                               required>
                        <p v-if="errors.email" class="text-danger">{{ errors.email[0] }}</p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" id="phone" v-model="form.phone" class="form-control form-control-md"
                               required>
                        <p v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="note">Message</label>
                        <textarea id="note" v-model="form.note" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button @click="onSubmit()" class="btn btn-primary btn-lg px-5">Gửi</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import request from "../utils/request"

export default {
    name: "contact",
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                type: 'guest'
            },
            errors: [],
            success: ''
        }
    },
    methods: {
        onSubmit() {
            request.post('/contact', this.form)
                .then((response) => {
                    if (response.data.error == true) {
                        this.errors = response.data.message
                        this.success = ''
                    } else {
                        this.errors = []
                        this.success = "Gửi đăng ký thành công."
                    }
                })
                .catch((error) => {

                })
        },
    }
}
</script>

<style scoped>

</style>
