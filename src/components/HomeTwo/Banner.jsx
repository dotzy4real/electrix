import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import ModalVideo from 'react-modal-video';
import BannerBgImage1 from '../../assets/images/main-slider/4.jpg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    loop: true,
	navigation: {
        clickable: true,
    },
};

function Banner({ className }) {
	  const [isOpen, setOpen] = useState(false);
    return (
        <>
    <section className={`banner-section-three ${className || ''}`}>
        <Swiper {...swiperOptions} className="banner-carousel owl-theme">
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">WELCOME TO ELECTRICITY</span>
						<h1 className="title animate-3">Build Quality<br/>Electrician Item.</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
						<div className="video-box animate-4">
							<a onClick={() => setOpen(true)} className="play-now" data-fancybox="gallery" data-caption=""><i className="icon fa fa-play" aria-hidden="true"></i></a>
						</div>
						<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">WELCOME TO ELECTRICA</span>
						<h1 className="title animate-3">Build <span>Quality<br className="d-none d-md-block"/>Electrical Services</span></h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
						<div className="video-box animate-4">
							<a onClick={() => setOpen(true)} className="play-now" data-fancybox="gallery" data-caption=""><i className="icon fa fa-play" aria-hidden="true"></i></a>
						</div>
						<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">WELCOME TO ELECTRICA</span>
						<h1 className="title animate-3">Build <span>Quality<br className="d-none d-md-block"/>Electrical Services.</span></h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
						<div className="video-box animate-4">
							<a onClick={() => setOpen(true)} className="play-now" data-fancybox="gallery" data-caption=""><i className="icon fa fa-play" aria-hidden="true"></i></a>
						</div>
						<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
					</div>
				</div>
			</SwiperSlide>
		</Swiper>
	</section>
        </>
    );
}

export default Banner;
