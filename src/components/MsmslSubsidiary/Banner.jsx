import React from 'react';
import { Link } from 'react-router-dom';
{/*import BannerImage1 from '../../assets/images/main-slider/1.jpg';*/}
import BannerImage1 from '../../assets/images/msmsl/homebanners/homebanner1.jpeg';
import BannerImage2 from '../../assets/images/msmsl/homebanners/homebanner2.jpeg';
import BannerImage3 from '../../assets/images/msmsl/homebanners/homebanner3.jpeg';
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
        delay: 25000,
        disableOnInteraction: false,
    },
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};

function Banner({ className }) {
    return (
        <>
            {/* <!-- Banner Section Three--> */}
            <section className={`banner-section-one ${className || ''}`}>
                <Swiper {...swiperOptions} className="banner-carousel owl-theme msmsl">
                    <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
                    <div className="swiper-button-next">{/**/}<i className="fa fa-chevron-right"></i></div>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage1})`}}/>
                        <div className="shape-9"/>
                        <div className="shape-10"/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-2">Began operations in September 2017</span>
                                <h1 className="title animate-3">Ultra-modern  <br className="d-none d-md-block"/>  company</h1>
                                <div className="text animate-4">high-tech smart and non-smart pre-paid electricity meters and meter boxes used in power measurement and revenue assurance locally and within the African region. MSMSL is staffed by a team
                                </div>
                                <div className="btn-box animate-5">
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-light"><span className="btn-title">Learn more</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage2})`}}/>
                        <div className="shape-9"/>
                        <div className="shape-10"/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-2">Seasoned Professional Team at work</span>
                                <h1 className="title animate-3">We have the  <br className="d-none d-md-block"/>  best team</h1>
                                <div className="text animate-4">international exposure that encourages knowledge and skill transfer as a fundamental part of our collaboration strategy</div>
                                <div className="btn-box animate-5">
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-light"><span className="btn-title">Book consultation</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage3})`}}/>
                        <div className="shape-9"/>
                        <div className="shape-10"/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-2">Exceptional customer service</span>
                                <h1 className="title animate-3">Seasoned  <br className="d-none d-md-block"/>  professionals</h1>
                                <div className="text animate-4">superior product quality continues to endear us to Customers within and outside Nigeria</div>
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
