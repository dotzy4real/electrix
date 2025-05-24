import React from 'react';
import TestimonialsImg1 from '../../assets/images/resource/testi2-1.jpg';
import TestimonialsImg2 from '../../assets/images/resource/testi2-2.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

const swiperOptions = {
    modules: [Autoplay, Pagination],
    slidesPerView: 2,
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
            slidesPerView: 1,
        },
        991: {
            slidesPerView: 1,
        },
        1199: {
            slidesPerView: 2,
        },
        1350: {
            slidesPerView: 2,
        },
    }
};
function Testimonial({ className }) {
    return (
        <>
    <section className={`testimonial-section-two style-four ${className || ''}`}>
		<div className="auto-container">
		  	<div className="sec-title text-center light">
				<span className="sub-title">TESTIMONIALS</span>
				<h2>What Our Client <br />Say about us</h2>
	    	</div>
		  	<div className="carousel-outer">
                <Swiper {...swiperOptions} className="testimonial-carousel-three owl-theme default-dots">
                    <SwiperSlide className="testimonial-block-two">
                        <div className="inner-box">
                        <div className="image-box">
                            <figure className="thumb"><img src={TestimonialsImg1} alt="Image"/></figure>
                        </div>
                        <div className="content-box">
                            <h4 className="reason">Great Service</h4>
                            <div className="rating"> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> </div>
                            <div className="text">Build and implement innovative, profitable and sustainable products and services that help</div>
                            <h6 className="name">Mark Wooden</h6>
                            <span className="designation">Admin</span>
                        </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="testimonial-block-two">
                        <div className="inner-box">
                        <div className="image-box">
                            <figure className="thumb"><img src={TestimonialsImg2} alt="Image"/></figure>
                        </div>
                        <div className="content-box">
                            <h4 className="reason">Great Service</h4>
                            <div className="rating"> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> </div>
                            <div className="text">Build and implement innovative, profitable and sustainable products and services that help</div>
                            <h6 className="name">Mark Wooden</h6>
                            <span className="designation">Admin</span>
                        </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="testimonial-block-two">
                        <div className="inner-box">
                        <div className="image-box">
                            <figure className="thumb"><img src={TestimonialsImg1} alt="Image"/></figure>
                        </div>
                        <div className="content-box">
                            <h4 className="reason">Great Service</h4>
                            <div className="rating"> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> <i className="fa fa-star"></i> </div>
                            <div className="text">Build and implement innovative, profitable and sustainable products and services that help</div>
                            <h6 className="name">Mark Wooden</h6>
                            <span className="designation">Admin</span>
                        </div>
                        </div>
                    </SwiperSlide>
				</Swiper>
		  	</div>
		</div>
	</section>
        </>
    );
}

export default Testimonial;
