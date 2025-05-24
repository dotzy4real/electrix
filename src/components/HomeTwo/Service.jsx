import React from 'react';
import { Link } from 'react-router-dom';
import Service1 from '../../assets/images/resource/service2-1.jpg';
import Service2 from '../../assets/images/resource/service2-2.jpg';
import Service3 from '../../assets/images/resource/service2-3.jpg';
import ServiceBgImg from '../../assets/images/background/7.jpg';
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
            slidesPerView: 2,
        },
        767: {
            slidesPerView: 2,
        },
        991: {
            slidesPerView: 3,
        },
        1199: {
            slidesPerView: 3,
        },
        1350: {
            slidesPerView: 3,
        },
    }
};

function Service({ className }) {
    return (
        <>
    <section id="services" className={`services-section-two ${className || ''}`}>
		<div className="bg bg-image" style={{ backgroundImage: `url(${ServiceBgImg})`}}/>
		<div className="auto-container">
			<div className="sec-title text-center">
				<span className="sub-title">WHAT WE DO</span>
				<h2 className="service-title">We Offer Cost Efficient <br />Electrical Services</h2>
			</div>
			<Swiper {...swiperOptions} className="services-carousel owl-theme default-dots">
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service1} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-049-wiring"></i>
								<h4 className="title"><Link to="/page-service-details">Wiring Solutions</Link></h4>
								<div className="text">Safe, efficient wiring installation and repair for residential and commercial properties.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service2} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-024-socket"></i>
								<h4 className="title"><Link to="/page-service-details">Air Conditioning</Link></h4>
								<div className="text">Inspections and upgrades to protect from electrical hazards and ensure compliance.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service3} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-001-light-bulb"></i>
								<h4 className="title"><Link to="/page-service-details">Indoor Lighting</Link></h4>
								<div className="text">Install surge protectors to safeguard appliances and electronics from power surges.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service1} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-049-wiring"></i>
								<h4 className="title"><Link to="/page-service-details">House Maintenance</Link></h4>
								<div className="text">Professional installation and maintenance of backup generators for uninterrupted power.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>
			</Swiper>
		</div>
	</section>
        </>
    );
}

export default Service;
