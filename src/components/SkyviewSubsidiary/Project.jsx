import React from 'react';
import { Link } from 'react-router-dom';
import ProjectImage1 from '../../assets/images/resource/project1-1.jpg';
import ProjectImage2 from '../../assets/images/resource/project1-2.jpg';
import ProjectImage3 from '../../assets/images/resource/project1-3.jpg';
import ProjectImage4 from '../../assets/images/resource/project1-4.jpg';
import ProjectImage5 from '../../assets/images/resource/project1-5.jpg';
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
            <section id="projects" className={`project-section two ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center">
                        <span className="sub-title">OUR PORTFOLIO</span>
                        <h2>We delivered results for <br/>
                        industry leaders</h2>
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
                            <h4 className="title"><Link to="/page-project-details">Roof Construction</Link></h4>
                            <span className="cat">Roof Construction</span>
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
                            <h4 className="title"><Link to="/page-project-details">Classic Roofing</Link></h4>
                            <span className="cat">Residential</span>
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
                            <h4 className="title"><Link to="/page-project-details">Winter Maintenance</Link></h4>
                            <span className="cat">Installation</span>
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
                            <h4 className="title"><Link to="/page-project-details">Modern Pattern Style</Link></h4>
                            <span className="cat">Repair</span>
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
                            <h4 className="title"><Link to="/page-project-details">Renovation Roof</Link></h4>
                            <span className="cat">Residential</span>
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
                            <h4 className="title"><Link to="/page-project-details">Fixing Storm Damage</Link></h4>
                            <span className="cat">Maintenance</span>
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
