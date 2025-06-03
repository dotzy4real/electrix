import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import ModalVideo from 'react-modal-video';
import BannerBgImage1 from '../../assets/images/skyview/homebanners/homebanner1.jpeg';
import BannerBgImage2 from '../../assets/images/skyview/homebanners/homebanner2.jpeg';
import BannerBgImage3 from '../../assets/images/skyview/homebanners/homebanner3.jpeg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
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
	  const [isOpen, setOpen] = useState(false);
    return (
        <>
    <section className={`banner-section-three ${className || ''}`}>
        <Swiper {...swiperOptions} className="banner-carousel owl-theme skyview">
                    <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
                    <div className="swiper-button-next">{/**/}<i className="fa fa-chevron-right"></i></div>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">Ultra-modern company</span>
						<h1 className="title animate-3">Began operations in September 2017</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
						{/*
						<div className="video-box animate-4">
							<a onClick={() => setOpen(true)} className="play-now" data-fancybox="gallery" data-caption=""><i className="icon fa fa-play" aria-hidden="true"></i></a>
						</div>
						<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />*/}
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">We have the best team</span>
						<h1 className="title animate-3">Seasoned Professional <br/>Team at work</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
						{/*<div className="video-box animate-4">
							<a onClick={() => setOpen(true)} className="play-now" data-fancybox="gallery" data-caption=""><i className="icon fa fa-play" aria-hidden="true"></i></a>
						</div>
						<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />*/}
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage3})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">Seasoned Professionals</span>
						{/*<h1 className="title animate-3">Build <span>Quality<br className="d-none d-md-block"/>Electrical Services.</span></h1>*/}
						<h1 className="title animate-3">Exceptional Customer Services.</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
						{/*<div className="video-box animate-4">
							<a onClick={() => setOpen(true)} className="play-now" data-fancybox="gallery" data-caption=""><i className="icon fa fa-play" aria-hidden="true"></i></a>
						</div>
						<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />*/}
					</div>
				</div>
			</SwiperSlide>
		</Swiper>
	</section>
        </>
    );
}

export default Banner;
