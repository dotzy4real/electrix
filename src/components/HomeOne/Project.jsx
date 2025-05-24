import React from 'react';
import { Link } from 'react-router-dom';
import ProjectImage1 from '../../assets/images/resource/projects/252mw_gas.jpg';
import ProjectImage2 from '../../assets/images/resource/projects/36.5_emergency.jpg';
import ProjectImage3 from '../../assets/images/resource/projects/20mw_gas_plant.jpg';
import ProjectImage4 from '../../assets/images/resource/projects/3mw_diesel_powerplant.jpg';
import ProjectImage5 from '../../assets/images/resource/projects/transmission_substation.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';


const swiperOptions = {
    modules: [Autoplay, Pagination],
    slidesPerView: 5,
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
            slidesPerView: 3,
        },
        991: {
            slidesPerView: 4,
        },
        1199: {
            slidesPerView: 5,
        },
        1350: {
            slidesPerView: 5,
        },
    }
};

function Project({ className }) {
    return (
        <>
            <section id="projects" className={`project-section ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center light">
                        <span className="sub-title">OUR WORK</span>
                        <h2>We Have Delivered Best Electrical <br/>Solutions Across Africa</h2>
                    </div>
                </div>
                <div className="outer-box">
                <Swiper {...swiperOptions} className="projects-carousel owl-theme default-dots">
                    <SwiperSlide className="project-block">
                        <div className="inner-box">
                            <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage1} alt="Image"/></Link></figure>
                            </div>
                            <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="far fa-arrow-up"></i></Link><br/>
                            <h4 className="title"><Link to="/page-project-details">EPC of 252 MW Gas Power Plant Construction at Omoku</Link></h4>
                            <span className="cat">Plant Construction</span>
                            </div>
                            <div className="overlay-1"></div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="project-block">
                        <div className="inner-box">
                            <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
                            </div>
                            <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="far fa-arrow-up"></i></Link><br/>
                            <h4 className="title"><Link to="/page-project-details">EPC of 36.5 MW Emergency Diesel IPP Completed at Sierra-Leone</Link></h4>
                            <span className="cat">Plant Construction</span>
                            </div>
                            <div className="overlay-1"></div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="project-block">
                        <div className="inner-box">
                            <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage3} alt="Image"/></Link></figure>
                            </div>
                            <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="far fa-arrow-up"></i></Link><br/>
                            <h4 className="title"><Link to="/page-project-details">EPC of 20MW Gas Power Plant Construction at Escravos</Link></h4>
                            <span className="cat">Plant Construction</span>
                            </div>
                            <div className="overlay-1"></div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="project-block">
                        <div className="inner-box">
                            <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage4} alt="Image"/></Link></figure>
                            </div>
                            <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="far fa-arrow-up"></i></Link><br/>
                            <h4 className="title"><Link to="/page-project-details">EPC of 3MW Diesel Power Plant Completed at Obudu, Cross River State</Link></h4>
                            <span className="cat">Plant Construction</span>
                            </div>
                            <div className="overlay-1"></div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="project-block">
                        <div className="inner-box">
                            <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage5} alt="Image"/></Link></figure>
                            </div>
                            <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="far fa-arrow-up"></i></Link><br/>
                            <h4 className="title"><Link to="/page-project-details">EPC of 2x30MVA, 132/33kV Transmission Substation Completed & Commissioned</Link></h4>
                            <span className="cat">Transmission Commission</span>
                            </div>
                            <div className="overlay-1"></div>
                        </div>
                    </SwiperSlide>
                </Swiper>
                </div>
            </section>
        </>
    );
}

export default Project;
