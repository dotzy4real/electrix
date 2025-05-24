import React from 'react';
import { Link } from 'react-router-dom';
import BannerImage1 from '../../assets/images/main-slider/1.jpg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
    spaceBetween: 30,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    loop: true,
};

function Banner({ className }) {
    return (
        <>
            {/* <!-- Banner Section Three--> */}
            <section className={`banner-section-one ${className || ''}`}>
                <Swiper {...swiperOptions} className="banner-carousel owl-theme">
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage1})`}}/>
                        <div className="shape-9"/>
                        <div className="shape-10"/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-2">WELCOME TO ELECTRICITY</span>
                                <h1 className="title animate-3">Electicity <br className="d-none d-md-block"/>  And Servicing</h1>
                                <div className="text animate-4">Whether you're a homeowner, business owner, or community leader, a <br/> we're here to light up your sustainable energy solutions that.</div>
                                <div className="btn-box animate-5">
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-light"><span className="btn-title">DISCOVER MORE</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage1})`}}/>
                        <div className="shape-9"/>
                        <div className="shape-10"/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-2">WELCOME TO ELECTRICITY</span>
                                <h1 className="title animate-3">Electicity <br className="d-none d-md-block"/>  And Servicing</h1>
                                <div className="text animate-4">Whether you're a homeowner, business owner, or community leader, a <br/> we're here to light up your sustainable energy solutions that.</div>
                                <div className="btn-box animate-5">
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-light"><span className="btn-title">DISCOVER MORE</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                </Swiper>
            </section>
            {/* <!--END Banner Section Three --> */}
        </>
    );
}

export default Banner;
