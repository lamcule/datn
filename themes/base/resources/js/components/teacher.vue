<template>
    <div class="content">
        <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4"
        >
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-7">
                        <h2 class="mb-0">Khóa học</h2>
                        <p>Lorem ipsum dolor si amet consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-breadcrumns border-bottom">
            <div class="container">
                <a href="/">Trang chủ</a>
                <span class="mx-3 icon-keyboard_arrow_right"></span>
                <span class="current">Giảng viên</span>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div v-for="(teacher, key) in teachers" class="col-lg-4 col-md-6 mb-5 mb-lg-5">
                        <div class="feature-1 border person text-center">
                            <img src="images/person_1.jpg" alt="Image" class="img-fluid">
                            <div class="feature-1-content">
                                <h2>{{ teacher.name }}</h2>
                                <p>{{ teacher.profile.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-bg style-1" style="background-image: url('/themes/base/images/hero_1.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                        <span class="icon flaticon-mortarboard"></span>
                        <h3>Sư mệnh của chúng tôi</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure
                            repellat quis delectus ea? Dolore, amet reprehenderit.</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                        <span class="icon flaticon-school-material"></span>
                        <h3>Cha khóa thành công</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure
                            repellat quis delectus ea?
                            Dolore, amet reprehenderit.</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                        <span class="icon flaticon-library"></span>
                        <h3>Tầm nhìn</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure
                            repellat quis delectus ea?
                            Dolore, amet reprehenderit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import request from "../utils/request";

export default {
    data() {
        return {
            teachers: [],
        }
    },
    mounted() {
        this.getTeacher()
    },
    methods: {
        getTeacher() {
            request.get('/active-teacher')
                .then((response) => {
                    this.teachers = response.data.data
                })
        },
    }
}
</script>

<style scoped>

</style>
