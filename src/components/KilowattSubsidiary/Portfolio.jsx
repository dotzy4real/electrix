import React from 'react';
import { Link } from 'react-router-dom';
import ProjectImage1 from '../../assets/images/resource/portfolio5-1.jpg';
import ProjectImage2 from '../../assets/images/resource/portfolio5-2.jpg';
import ProjectImage3 from '../../assets/images/resource/portfolio5-3.jpg';
import ClientsImage1 from '../../assets/images/clients/1.png';
import ClientsImage2 from '../../assets/images/clients/2.png';
import ClientsImage3 from '../../assets/images/clients/3.png';
import ClientsImage4 from '../../assets/images/clients/4.png';
import ClientsImage5 from '../../assets/images/clients/5.png';
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
    loop: true,
    breakpoints: {
        320: {
            slidesPerView: 1,
        },
        575: {
            slidesPerView: 1,
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

const swiperOptions2 = {
    modules: [Autoplay, Pagination],
    slidesPerView: 5,
    spaceBetween: 30,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
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
            slidesPerView: 3,
        },
        991: {
            slidesPerView: 3,
        },
        1199: {
            slidesPerView: 4,
        },
        1350: {
            slidesPerView: 5,
        },
    }
};


function Project2({ className }) {
    return (
        <>
    	<section id="projects" className={`portfolio-section-five ${className || ''}`}>
			<div className="auto-container">
				<div className="sec-title light">
					<div className="row align-items-end justify-content-between">
						<div className="col-lg-7">
							<span className="sub-title">RECENT PROJECTS</span>
							<h2 className="service-title">Checking  Our Electrician <br/>Portfolio for you.</h2> 
						</div>
						<div className="col-lg-5 d-lg-flex justify-content-end">
							<Link to="/page-about" className="theme-btn btn-style-one bg-light"><span className="btn-title">DISCOVER MORE</span></Link>
						</div>
					</div>
				</div>
	
				<div className="carousel-outer">
					<Swiper {...swiperOptions} className="projects-carousel-seven owl-theme default-dots">
						<SwiperSlide className="portfolio-block-six">
							<div className="inner-box">
								<figure className="image"><Link to="/page-project-details"><img src={ProjectImage1} alt="Image"/></Link></figure>
							</div>
						</SwiperSlide>
						<SwiperSlide className="portfolio-block-six">
							<div className="inner-box">
								<figure className="image"><Link to="/page-project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
							</div>
						</SwiperSlide>
						<SwiperSlide className="portfolio-block-six">
							<div className="inner-box">
								<figure className="image"><Link to="/page-project-details"><img src={ProjectImage3} alt="Image"/></Link></figure>
							</div>
						</SwiperSlide>
						<SwiperSlide className="portfolio-block-six">
							<div className="inner-box">
								<figure className="image"><Link to="/page-project-details"><img src={ProjectImage1} alt="Image"/></Link></figure>
							</div>
						</SwiperSlide>
					</Swiper>
				</div>
				<div className="sponsors-outer"> 
					<Swiper {...swiperOptions2} className="clients-carousel owl-theme disable-navs">
						<SwiperSlide className="client-block"><Link to="#" className="image"><img src={ClientsImage1} alt="Image"/><img src={ClientsImage1} alt="Image"/></Link></SwiperSlide>
						<SwiperSlide className="client-block"><Link to="#" className="image"><img src={ClientsImage2} alt="Image"/><img src={ClientsImage2} alt="Image"/></Link></SwiperSlide>
						<SwiperSlide className="client-block"><Link to="#" className="image"><img src={ClientsImage3} alt="Image"/><img src={ClientsImage3} alt="Image"/></Link></SwiperSlide>
						<SwiperSlide className="client-block"><Link to="#" className="image"><img src={ClientsImage4} alt="Image"/><img src={ClientsImage4} alt="Image"/></Link></SwiperSlide>
						<SwiperSlide className="client-block"><Link to="#" className="image"><img src={ClientsImage5} alt="Image"/><img src={ClientsImage5} alt="Image"/></Link></SwiperSlide>
						<SwiperSlide className="client-block"><Link to="#" className="image"><img src={ClientsImage3} alt="Image"/><img src={ClientsImage3} alt="Image"/></Link></SwiperSlide>
					</Swiper>
				</div>
			</div>
		</section>
        </>
    ); 
}

export default Project2;
