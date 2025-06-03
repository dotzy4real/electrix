import React from 'react';
import { Link } from 'react-router-dom';
import ProjectBgImage from '../../assets/images/kilowatt/projects/project_back.jpg';
import ProjectImage1 from '../../assets/images/kilowatt/projects/project1.jpg';
import ProjectImage2 from '../../assets/images/kilowatt/projects/project2.jpg';
import ProjectImage3 from '../../assets/images/kilowatt/projects/project3.jpg';
import ProjectImage4 from '../../assets/images/kilowatt/projects/project4.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';


const swiperOptions = {
    modules: [Autoplay, Pagination],
    slidesPerView: 4,
    spaceBetween: 30,
    autoplay: {
        delay: 5000000,
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
            <section className={`project-section-three kilowatt ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ProjectBgImage})` }}/>
                <div className="auto-container">
                    <div className="sec-title light">
                        <div className="row align-items-center">
                            <div className="col-lg-7">
                                <span className="sub-title">OUR BENIFITIES</span>
                                <h2>Recently Completed <br />Projects</h2>
                            </div>
                            <div className="col-lg-5">
                                <div className="text">We have been awarded big projects from credible clients and we have also delivered these projects well above their expectations.</div>
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
                                <h4 className="title"><Link to="/page-project-details">Engineering, Procurement and Design of 1 Mega Watt solar off grid village electrification inica Company Akugbene</Link></h4>
                                <span className="cat">Power System</span>
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
                                <h4 className="title"><Link to="/page-project-details">Consultant For Pre-Feasibility Studies, Justification And Co-ordination Studies For The Power System </Link></h4>
                                <span className="cat">Power System</span>
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
                                <h4 className="title"><Link to="/page-project-details">Maintenance and Rehabilitation of Energy –Efficient Solar Street lights in Niger Delta Region (Lot 3), Rivers state</Link></h4>
                                <span className="cat">Solar Light</span>
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
                                <h4 className="title"><Link to="/page-project-details">Emergency construction of 5.0M 11KV overhead line single circuit to evacuate power</Link></h4>
                                <span className="cat">Power System</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>
                        </Swiper>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Project;
