<template>
    <div class="content">
        <div class="hero-slide owl-carousel site-blocks-cover">
            <div class="intro-section" style="background-image: url('themes/base/images/hero_1.jpg');">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                            <h1>Academics University</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-section" style="background-image: url('themes/base/images/hero_1.jpg');">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                            <h1>You Can Learn Anything</h1>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="site-section">
            <div class="container">
                <div class="row mb-5 justify-content-center text-center">
                    <div class="col-lg-4 mb-5">
                        <h2 class="section-title-underline mb-5">
                            <span>Vì sao nên học tiếng anh tại Academics?</span>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">

                        <div class="feature-1 border">
                            <div class="icon-wrapper bg-primary">
                                <span class="flaticon-mortarboard text-white"></span>
                            </div>
                            <div class="feature-1-content">
                                <h2>10.000</h2>
                                <p>học viên đã theo học
                                    trên toàn quốc</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <div class="feature-1 border">
                            <div class="icon-wrapper bg-primary">
                                <span class="flaticon-school-material text-white"></span>
                            </div>
                            <div class="feature-1-content">
                                <h2>3 lợi ích 1 khóa học</h2>
                                <p>Chương trình tích hợp độc quyền
                                    giảng dạy tiếng Anh giao tiếp & học thuật,
                                    đào tạo kỹ năng làm bài thi tiếng Anh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <div class="feature-1 border">
                            <div class="icon-wrapper bg-primary">
                                <span class="flaticon-library text-white"></span>
                            </div>
                            <div class="feature-1-content">
                                <h2>100</h2>
                                <p>giáo viên kinh nghiệm
                                    được chứng nhận quốc tế</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="site-section">
            <div class="container">


                <div class="row mb-5 justify-content-center text-center">
                    <div class="col-lg-6 mb-5">
                        <h2 class="section-title-underline mb-3">
                            <span>Khóa học phổ biến</span>
                        </h2>
                        <p>Khóa học mới nhất tại trung tâm</p>
                    </div>
                </div>

                <div class="row">
                    <div v-for="(course, index) in courses" :key="index" class="course-1-item col-md-4">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="/themes/base/images/course_1.jpg" alt="Image"
                                                              class="img-fluid"></a>
                            <div class="price">{{ course.tuition }}</div>
                            <div class="category"><h3>{{ course.name }}</h3></div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>{{ course.type }}</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">{{ course.description }}</p>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Enroll In
                                This Course</a></p>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="section-bg style-1" style="background-image: url('/themes/base/images/about_1.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <h2 class="section-title-underline style-2">
                            <span>About Our University</span>
                        </h2>
                    </div>
                    <div class="col-lg-8">
                        <p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rem nesciunt quaerat
                            ad reiciendis perferendis voluptate fugiat sunt fuga error totam.</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus assumenda omnis tempora
                            ullam alias amet eveniet voluptas, incidunt quasi aut officiis porro ad, expedita saepe
                            necessitatibus rem debitis architecto dolore? Nam omnis sapiente placeat blanditiis voluptas
                            dignissimos, itaque fugit a laudantium adipisci dolorem enim ipsum cum molestias? Quod quae
                            molestias modi fugiat quisquam. Eligendi recusandae officiis debitis quas beatae
                            aliquam?</p>
                        <p><a href="#">Read more</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- // 05 - Block -->
        <div class="site-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-lg-4">
                        <h2 class="section-title-underline">
                            <span>Giảng viên của chúng tôi</span>
                        </h2>
                    </div>
                </div>


                <div class="owl-slide owl-carousel">
                    <div v-for="(teacher, index) in teachers" :key="index" class="ftco-testimonial-1">
                        <div class="ftco-testimonial-vcard d-flex align-items-center mb-4">
                            <img src="/themes/base/images/person_1.jpg" alt="Image" class="img-fluid mr-3">
                            <div>
                                <h3>{{ teacher.name }}</h3>
                            </div>
                        </div>
                        <div>
                            <p>{{ teacher.profile.description }}</p>
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
                        <h3>Our Philosphy</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure
                            repellat quis delectus ea? Dolore, amet reprehenderit.</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                        <span class="icon flaticon-school-material"></span>
                        <h3>Academics Principle</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure
                            repellat quis delectus ea?
                            Dolore, amet reprehenderit.</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                        <span class="icon flaticon-library"></span>
                        <h3>Key of Success</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis recusandae, iure
                            repellat quis delectus ea?
                            Dolore, amet reprehenderit.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="news-updates">
            <div class="container">

                <div class="row">
                    <div class="col-lg-9">
                        <div class="section-heading">
                            <h2 class="text-black">News &amp; Updates</h2>
                            <a href="#">Read All News</a>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="post-entry-big">
                                    <a href="news-single.html" class="img-link"><img
                                        src="/themes/base/images/blog_large_1.jpg" alt="Image" class="img-fluid"></a>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <a href="#">June 6, 2019</a>
                                            <span class="mx-1">/</span>
                                            <a href="#">Admission</a>, <a href="#">Updates</a>
                                        </div>
                                        <h3 class="post-heading"><a href="news-single.html">Campus Camping and Learning
                                            Session</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="post-entry-big horizontal d-flex mb-4">
                                    <a href="news-single.html" class="img-link mr-4"><img
                                        src="/themes/base/images/blog_1.jpg" alt="Image" class="img-fluid"></a>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <a href="#">June 6, 2019</a>
                                            <span class="mx-1">/</span>
                                            <a href="#">Admission</a>, <a href="#">Updates</a>
                                        </div>
                                        <h3 class="post-heading"><a href="news-single.html">Campus Camping and Learning
                                            Session</a></h3>
                                    </div>
                                </div>

                                <div class="post-entry-big horizontal d-flex mb-4">
                                    <a href="news-single.html" class="img-link mr-4"><img
                                        src="/themes/base/images/blog_2.jpg" alt="Image" class="img-fluid"></a>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <a href="#">June 6, 2019</a>
                                            <span class="mx-1">/</span>
                                            <a href="#">Admission</a>, <a href="#">Updates</a>
                                        </div>
                                        <h3 class="post-heading"><a href="news-single.html">Campus Camping and Learning
                                            Session</a></h3>
                                    </div>
                                </div>

                                <div class="post-entry-big horizontal d-flex mb-4">
                                    <a href="news-single.html" class="img-link mr-4"><img
                                        src="/themes/base/images/blog_1.jpg" alt="Image" class="img-fluid"></a>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <a href="#">June 6, 2019</a>
                                            <span class="mx-1">/</span>
                                            <a href="#">Admission</a>, <a href="#">Updates</a>
                                        </div>
                                        <h3 class="post-heading"><a href="news-single.html">Campus Camping and Learning
                                            Session</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="section-heading">
                            <h2 class="text-black">Campus Videos</h2>
                            <a href="#">View All Videos</a>
                        </div>
                        <a href="https://vimeo.com/45830194" class="video-1 mb-4" data-fancybox="" data-ratio="2">
              <span class="play">
                <span class="icon-play"></span>
              </span>
                            <img src="/themes/base/images/course_5.jpg" alt="Image" class="img-fluid">
                        </a>
                        <a href="https://vimeo.com/45830194" class="video-1 mb-4" data-fancybox="" data-ratio="2">
                <span class="play">
                  <span class="icon-play"></span>
                </span>
                            <img src="/themes/base/images/course_5.jpg" alt="Image" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section ftco-subscribe-1" style="background-image: url('/themes/base/images/bg_1.jpg')">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h2>Subscribe to us!</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,</p>
                    </div>
                    <div class="col-lg-5">
                        <form action="" class="d-flex">
                            <input type="text" class="rounded form-control mr-2 py-3" placeholder="Enter your email">
                            <button class="btn btn-primary rounded py-3 px-4" type="submit">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import request from "../utils/request"

export default {
    data() {
        return {
            courses: [],
            teachers: [],
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        getCourse() {
            request.get('/active-course', {per_page: 3})
                .then((response) => {
                    this.courses = response.data.data
                })
        },
        getTeacher() {
            request.get('/active-teacher')
                .then((response) => {
                    this.teachers = response.data.data
                })
        },
        fetchData() {
            this.getCourse()
            this.getTeacher()
        },
    }
}
</script>

<style>
.content {
    padding-top: 80px;
}
</style>
