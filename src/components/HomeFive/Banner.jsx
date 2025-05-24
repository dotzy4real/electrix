import React from 'react';
import CounterUp2 from '../../lib/CounterUp2.jsx'; 
import { Link } from 'react-router-dom';
import BannerBgImage from '../../assets/images/main-slider/9.jpg';
import BannerImage from '../../assets/images/main-slider/rotate-shine-1.png';
import BannerImage1 from '../../assets/images/main-slider/img-5.png';
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
        delay: 35000,
        disableOnInteraction: false,
    },
    loop: true,
};

function Banner({ className }) {
	const percentage1 = 4938;
    return (
        <>
	<section className={`banner-section-five ${className || ''}`}>
		<div className="bg-image5" style={{ backgroundImage: `url(${BannerBgImage})`}}/>
		<Swiper {...swiperOptions} className="banner-carousel owl-theme">
			<SwiperSlide className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">WELCOME TO Electrica</span>
								<h2 className="title animate-3">Electicity <br className="d-none d-xl-block" />And Servicing</h2>
								<div className="text animate-4">We offer you Electricity services customized to suit your requirements. <br />Our dedication lies in finish the ideal solution for every project.</div>
								<div className="btn-box animate-5">
									<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
									<figure className="image animate-5 animate-x"><img src={BannerImage} alt="Image"/>
									</figure>
								</div>
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box">
								<div className="fact-counter-one">
									<h4 className="counter-title">TRUSTED BY</h4>
									<div className="count-box">
										<CounterUp2 count={percentage1} time={3} />
									</div>
								</div>
								<figure className="image animate-5 animate-x"><img src={BannerImage1} alt="Image"/>
								</figure>
							</div>
						</div>
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">WELCOME TO Electrica</span>
								<h2 className="title animate-3">Electicity <br className="d-none d-xl-block" />And Servicing</h2>
								<div className="text animate-4">We offer you Electricity services customized to suit your requirements. <br />Our dedication lies in finish the ideal solution for every project.</div>
								<div className="btn-box animate-5">
									<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
									<figure className="image animate-5 animate-x"><img src={BannerImage} alt="Image"/>
									</figure>
								</div>
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box">
								<div className="fact-counter-one">
									<h4 className="counter-title">TRUSTED BY</h4>
									<div className="count-box">
										<CounterUp2 count={percentage1} time={3} />
									</div>
								</div>
								<figure className="image animate-5 animate-x"><img src={BannerImage1} alt="Image"/>
								</figure>
							</div>
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
