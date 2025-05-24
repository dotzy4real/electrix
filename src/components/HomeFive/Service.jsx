import React from 'react';
import { Link } from 'react-router-dom';
import ProjectBgImage from '../../assets/images/background/33.jpg';
import ProjectImage1 from '../../assets/images/resource/project5-1.jpg';
import ProjectImage2 from '../../assets/images/resource/project5-2.jpg';
import ProjectImage3 from '../../assets/images/resource/project5-3.jpg';
import ProjectImage4 from '../../assets/images/resource/project5-4.jpg';
import ExpertImage1 from '../../assets/images/resource/expert1.jpg';
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


function Service({ className }) {
    return (
        <>
            <section id="services" className={`project-section-five ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ProjectBgImage})`}}/>
                <div className="auto-container">
                    <div className="sec-title text-center">
                        <span className="sub-title">OUR SERVICES</span>
                        <h2>We Delivered  Best <br />Results Services</h2>
                    </div>
                    <div className="carousel-outer">
                        <Swiper {...swiperOptions} className="projects-carousel-five owl-theme">
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage1} className="lightbox-image"><img src={ProjectImage1} alt="Image"/></Link></figure>
                                        <Link to="/page-project-details" className="icon"><i className="fa fa-long-arrow-alt-right"></i></Link>
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Maintenance</span>
                                        <h4 className="title"><Link to="/page-project-details">Wiring Solutions</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage2} className="lightbox-image"><img src={ProjectImage2} alt="Image"/></Link></figure>
                                        <Link to="/page-project-details" className="icon"><i className="fa fa-long-arrow-alt-right"></i></Link>
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Maintenance</span>
                                        <h4 className="title"><Link to="/page-project-details">Home Remodel</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage3} className="lightbox-image"><img src={ProjectImage3} alt="Image"/></Link></figure>
                                        <Link to="/page-project-details" className="icon"><i className="fa fa-long-arrow-alt-right"></i></Link>
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Maintenance</span>
                                        <h4 className="title"><Link to="/page-project-details">Kitchen Remodel</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage4} className="lightbox-image"><img src={ProjectImage4} alt="Image"/></Link></figure>
                                        <Link to="/page-project-details" className="icon"><i className="fa fa-long-arrow-alt-right"></i></Link>
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Maintenance</span>
                                        <h4 className="title"><Link to="/page-project-details">Office Building</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage2} className="lightbox-image"><img src={ProjectImage2} alt="Image"/></Link></figure>
                                        <Link to="/page-project-details" className="icon"><i className="fa fa-long-arrow-alt-right"></i></Link>
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Maintenance</span>
                                        <h4 className="title"><Link to="/page-project-details">Home Remodel</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                        </Swiper>
                    </div>
                    <div className="expert-info-box">
                        <div className="image-box">
                            <figure className="image"><img src={ExpertImage1} alt="Image"/></figure>
                            <i className="icon flaticon-037-capacitor"></i>
                        </div>
                        <div className="content-box">
                            <h4 className="expert-title">Simplify your Electrician</h4>
                            <div className="expert-text">A leader in electronics solutions since 2024</div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Service;
