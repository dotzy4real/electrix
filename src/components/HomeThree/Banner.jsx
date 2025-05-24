import React from 'react';
import { Link } from 'react-router-dom';
import BannerBgImage1 from '../../assets/images/main-slider/2.jpg';
import BannerBgImage2 from '../../assets/images/main-slider/3.jpg';
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
        delay: 3500,
        disableOnInteraction: false,
    },
    loop: true,
	navigation: {
        clickable: true,
    },
};

function Banner({ className }) {
    return (
        <>
			<section className={`banner-section-two ${className || ''}`}>
				<Swiper {...swiperOptions} className="banner-carousel owl-theme">
					<SwiperSlide className="slide-item">
						<div className="bg bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
						<div className="bg bg-image2" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
						<div className="shape-11 bounce-x"/>
						<div className="auto-container">
							<div className="content-box">
								<span className="sub-title animate-2">WELCOME TO ELECTRICITY</span>
								<h1 className="title animate-3"><span>Build an Quality <br className="d-none d-md-block"/>Electrical Services</span></h1>
								<div className="btn-box animate-4">
									<Link to="/page-about" className="theme-btn btn-style-one hvr-light"><span className="btn-title">Discover more</span></Link>
								</div>
							</div>
						</div>
					</SwiperSlide>
					<SwiperSlide className="slide-item">
						<div className="bg bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
						<div className="bg bg-image2" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
						<div className="shape-11 bounce-x"/>
						<div className="shape-12 bounce-y"/>
						<div className="shape-13 bounce-y"/>
						<div className="auto-container">
							<div className="content-box">
								<span className="sub-title animate-2">WELCOME TO ELECTRICITY</span>
								<h1 className="title animate-3"><span>Build an Quality <br className="d-none d-md-block"/>Electrical Services</span></h1>
								<div className="btn-box animate-4">
									<Link to="/page-about" className="theme-btn btn-style-one hvr-light"><span className="btn-title">Discover more</span></Link>
								</div>
							</div>
						</div>
					</SwiperSlide>
				</Swiper>
			</section>
        </>
    );
}

export default Banner;
