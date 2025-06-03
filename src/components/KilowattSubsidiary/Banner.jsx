import React from 'react';
import CounterUp2 from '../../lib/CounterUp2.jsx'; 
import { Link } from 'react-router-dom';
import BannerBgImage from '../../assets/images/resource/homebanners/homebanner1.jpeg';
import BannerImage from '../../assets/images/main-slider/rotate-shine-1.png';
{/*import BannerImage1 from '../../assets/images/main-slider/img-5.png';*/}
import BannerImage1 from '../../assets/images/kilowatt/homebanners/homebanner1.jpeg';
import BannerImage2 from '../../assets/images/kilowatt/homebanners/homebanner2.jpeg';
import BannerImage3 from '../../assets/images/kilowatt/homebanners/homebanner3.jpeg';
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
	const percentage1 = 105;
    return (
        <>
	<section className={`banner-section-five ${className || ''}`}>
		<div className="bg-image5" style={{ backgroundImage: `url(${BannerBgImage})`}}/>
		<Swiper {...swiperOptions} className="banner-carousel owl-theme kilowatt">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>
			<SwiperSlide className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">Utility Network Support</span>
								<h2 className="title animate-3">Faults<br className="d-none d-xl-block" />Identification</h2>
								<div className="text animate-4">Transformer refurbishment, maintenance, repairs and replacement, testing and commissioning of all sizes, up to 132kV.</div>
								<div className="btn-box animate-5">
									<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
									{/*<figure className="image animate-5 animate-x"><img src={BannerImage} alt="Image"/>
									</figure>*/}
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
								<figure className="image animate-5 animate-x"><img src={BannerImage3} alt="Image"/>
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
								<span className="sub-title animate-2">Systems Support</span>
								<h2 className="title animate-3">Rectification   <br className="d-none d-xl-block" />of faults.</h2>
								<div className="text animate-4">Troubleshooting, Refurbishment, Repair and Maintenance of Industrial Pumps, Drives, Valves, Motor Control Centres (MCC), Distributed Control Systems (DCS) and Electronic Control Systems.</div>
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
								<figure className="image animate-5 animate-x"><img src={BannerImage2} alt="Image"/>
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
								<span className="sub-title animate-2">Industrial Plants Construction</span>
								<h2 className="title animate-3">Electrical <br className="d-none d-xl-block" /> Rectification.</h2>
								<div className="text animate-4">Construction, Refurbishment, Repairs and Maintenance of Equipment Control Panels, switchgear, etc.</div>
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
