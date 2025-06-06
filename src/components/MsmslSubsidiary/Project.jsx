import React from 'react';
import { Link } from 'react-router-dom';
import ProjectBgImage from '../../assets/images/msmsl/project_back.jpg';
import ProjectImage1 from '../../assets/images/msmsl/facility/facility1.jpg';
import ProjectImage2 from '../../assets/images/msmsl/facility/facility2.jpg';
import ProjectImage3 from '../../assets/images/msmsl/facility/facility3.jpg';
import ProjectImage4 from '../../assets/images/msmsl/facility/facility4.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';


const swiperOptions = {
    modules: [Autoplay, Pagination],
    slidesPerView: 4,
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
            slidesPerView: 4,
        },
    }
};

function Project({ className }) {
    return (
        <>
            <section className={`project-section-three ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ProjectBgImage})` }}/>
                <div className="auto-container">
                    <div className="sec-title light">
                        <div className="row align-items-center">
                            <div className="col-lg-7">
                                <span className="sub-title">OUR EQUIPMENTS</span>
                                <h2>World Class <br />Equipments We Use</h2>
                            </div>
                            <div className="col-lg-5">
                                <div className="text">In line with our vision to incorporate cutting-edge technology into the core of our operations, our facility has state-of-the-art equipment such as below: 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="carousel-outer">
                        <Swiper {...swiperOptions} className="projects-carousel-six owl-theme default-dots">
                            <SwiperSlide className="project-block">
                            <div className="inner-box">
                                <div className="image-box">
                                <figure className="image"><Link to="/page-project-details"><img src={ProjectImage1} alt="Image"/></Link></figure>
                                </div>
                                <div className="content-box">
                                <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link to="/page-project-details">Testing Benches</Link></h4>
                                <span className="cat">Metering Solution</span>
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
                                <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link to="/page-project-details">Plastic Injection Moulding Machine
                                </Link></h4>
                                <span className="cat">Metering Solution</span>
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
                                <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link to="/page-project-details">Energy Meter Voltage Withstand Equipment
                                </Link></h4>
                                <span className="cat">Metering Solution</span>
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
                                <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link to="/page-project-details">Programmable Dust Test Machine
                                </Link></h4>
                                <span className="cat">Metering Solution</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>
                            {/*
                            <SwiperSlide className="project-block">
                            <div className="inner-box">
                                <div className="image-box">
                                <figure className="image"><Link to="/page-project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
                                </div>
                                <div className="content-box">
                                <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link to="/page-project-details">Wiring Solutions</Link></h4>
                                <span className="cat">Electrica Company</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>*/}
                        </Swiper>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Project;
