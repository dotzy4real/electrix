import React from 'react';
import { Link } from 'react-router-dom';
import BannerImage1 from '../../assets/images/resource/homebanners/homebanner1.jpeg';
import BannerImage2 from '../../assets/images/resource/homebanners/homebanner2.jpeg';
import BannerImage3 from '../../assets/images/resource/homebanners/homebanner3.jpeg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
    spaceBetween: 50,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    loop: true,
    pagination: {
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};

function Banner({ className }) {
    return (
        <>
            <section className={`banner-section ${className || ''}`}>
                <Swiper {...swiperOptions} className="banner-carousel owl-theme">
      <div className="swiper-button-prev"><i class="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next">{/**/<i class="fa fa-chevron-right"></i>}</div>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage1})`}}/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-1">Integrated Electromechanical Solutions</span>
                                <h1 className="title animate-2">From Concept To  <br />Commissioning</h1>
                                {/*<h3 className="title-stroke animate-3">ELECTRIX GROUP</h3>*/}
                                <div className="btn-box animate-3">
                                    <Link to="/what-we-do" className="theme-btn btn-style-one bg-light"><span className="btn-title">WHAT WE OFFER</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage2})`}}/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-1">Customized Electrical Engineering Solutions</span>
                                <h1 className="title animate-2">To Our Valued  <br />Customers</h1>
                                {/*<h2 className="title-stroke animate-3">ELECTIC</h2>*/}
                                <div className="btn-box animate-3">
                                    <Link to="/contact" className="theme-btn btn-style-one bg-light"><span className="btn-title">CONTACT US NOW</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage3})`}}/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-1">We Bring Creativity To The Solutions We Develop</span>
                                <h1 className="title animate-2">Creativity In All  <br />We Do</h1>
                                {/*<h2 className="title-stroke animate-3">ELECTIC</h2>*/}
                                <div className="btn-box animate-3">
                                    <Link to="/who-we-are" className="theme-btn btn-style-one bg-light"><span className="btn-title">LEARN MORE</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                </Swiper>
                {/*<!-- Add Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>*/}
            </section>
        </>
    );
}

export default Banner;
