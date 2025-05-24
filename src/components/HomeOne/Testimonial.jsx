import React from 'react';
import TestimonialsBgImg from '../../assets/images/background/5.jpg';
import TestimonialsImg1 from '../../assets/images/resource/testi1-1.jpg';
import TestimonialsImg2 from '../../assets/images/resource/testi1-2.jpg';
import TestimonialsImg3 from '../../assets/images/resource/testi1-3.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

const swiperOptions = {
    modules: [Autoplay, Pagination],
    slidesPerView: 3,
    spaceBetween: 30,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        clickable: true,
    },
    loop: true,
    breakpoints: {
        320: {
            slidesPerView: 1,
        },
        575: {
            slidesPerView: 1,
        },
        767: {
            slidesPerView: 2,
        },
        991: {
            slidesPerView: 2,
        },
        1199: {
            slidesPerView: 3,
        },
        1350: {
            slidesPerView: 3,
        },
    }
};
function Testimonial({ className }) {
    return (
        <>
            <section className={`testimonial-section ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${TestimonialsBgImg})` }}/>
                <div className="testimonial-overlay">
                    <div className="shape-5 bounce-y"/>
                    <div className="auto-container">
                        <div className="sec-title text-center">
                            <span className="sub-title">OUR TESTIMONIALS</span>
                            <h2>Professional,Reliable<br/> & Cost Effective</h2>
                        </div>
                        <div className="carousel-outer">
                            <Swiper {...swiperOptions} className="testimonial-carousel-two owl-theme default-dots">
                                <SwiperSlide className="testimonial-block">
                                    <div className="inner-box">
                                    <figure className="thumb"><img src={TestimonialsImg1} alt="Image"/></figure>
                                    <h6 className="reason">Great Service</h6>
                                    <div className="rating">
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                    </div>
                                    <div className="text">I feel very happy and be proud to connect with this industry. I presume this is a very productive</div>
                                    <div className="info-box">
                                        <h6 className="name">Mark Wood</h6>
                                        <span className="designation">CEO, Buzicon</span>
                                    </div>
                                    <div className="icon-quote-2"></div>
                                    </div>
                                </SwiperSlide>
                                <SwiperSlide className="testimonial-block">
                                    <div className="inner-box">
                                    <figure className="thumb"><img src={TestimonialsImg2} alt="Image"/></figure>
                                    <h6 className="reason">Great Service</h6>
                                    <div className="rating">
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                    </div>
                                    <div className="text">I feel very happy and be proud to connect with this industry. I presume this is a very productive</div>
                                    <div className="info-box">
                                        <h6 className="name">Mark Wood</h6>
                                        <span className="designation">CEO, Buzicon</span>
                                    </div>
                                    <div className="icon-quote-2"></div>
                                    </div>
                                </SwiperSlide>
                                <SwiperSlide className="testimonial-block">
                                    <div className="inner-box">
                                    <figure className="thumb"><img src={TestimonialsImg3} alt="Image"/></figure>
                                    <h6 className="reason">Great Service</h6>
                                    <div className="rating">
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                    </div>
                                    <div className="text">I feel very happy and be proud to connect with this industry. I presume this is a very productive</div>
                                    <div className="info-box">
                                        <h6 className="name">Mark Wood</h6>
                                        <span className="designation">CEO, Buzicon</span>
                                    </div>
                                    <div className="icon-quote-2"></div>
                                    </div>
                                </SwiperSlide>
                                <SwiperSlide className="testimonial-block">
                                    <div className="inner-box">
                                    <figure className="thumb"><img src={TestimonialsImg1} alt="Image"/></figure>
                                    <h6 className="reason">Great Service</h6>
                                    <div className="rating">
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                        <i className="fa fa-star"></i>
                                    </div>
                                    <div className="text">I feel very happy and be proud to connect with this industry. I presume this is a very productive</div>
                                    <div className="info-box">
                                        <h6 className="name">Mark Wood</h6>
                                        <span className="designation">CEO, Buzicon</span>
                                    </div>
                                    <div className="icon-quote-2"></div>
                                    </div>
                                </SwiperSlide>
                            </Swiper>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Testimonial;
