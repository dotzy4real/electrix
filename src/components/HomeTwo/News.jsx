import React from 'react';
import { Link } from 'react-router-dom';
import News1 from '../../assets/images/resource/news-1.jpg';
import News2 from '../../assets/images/resource/news-2.jpg';
import News3 from '../../assets/images/resource/news-3.jpg';
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

function Blog({ className }) {
    return (
        <>
            <section id="news" className={`news-section-two ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">
                        <div className="title-column col-xl-4 col-lg-4 col-md-12">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="sub-title">OUR BLOG</span>
                                    <h2>Check Latest <br />Blog Post from <br />Blog List</h2>
                                    <div className="text">With over four decades of experience providing solutions to large-scale enterprises throughout the globe, we offer end-to-end.</div>
                                </div>
                            </div>
                        </div>

                        <div className="carousel-column col-xl-8 col-lg-8 col-md-12">
                            <div className="carousel-outer">
                                <Swiper {...swiperOptions} className="news-carousel owl-theme default-dots">
                                    
                                    <SwiperSlide className="news-block wow fadeInUp">
                                        <div className="inner-box">
                                            <div className="image-box">
                                                <figure className="image">
                                                    <Link to="/news-details">
                                                        <img src={News1} alt=""/>
                                                    </Link>
                                                </figure>
                                                <span className="date"><b>12</b> OCT</span>
                                            </div>
                                            <div className="content-box">
                                                <ul className="post-info">
                                                    <li><i className="fa fa-user"></i> By admin</li>
                                                    <li><i className="fa fa-tag"></i> electrical</li>
                                                </ul>
                                                <h4 className="title"><Link to="/news-details">Smart Home Wiring A Guide for Modern Electricians</Link></h4>
                                            </div>
                                            <div className="bottom-box">
                                                <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                                <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                            </div>
                                        </div>
                                    </SwiperSlide>
                                    <SwiperSlide className="news-block wow fadeInUp">
                                        <div className="inner-box">
                                            <div className="image-box">
                                                <figure className="image">
                                                    <Link to="/news-details">
                                                        <img src={News2} alt=""/>
                                                    </Link>
                                                </figure>
                                                <span className="date"><b>12</b> OCT</span>
                                            </div>
                                            <div className="content-box">
                                                <ul className="post-info">
                                                    <li><i className="fa fa-user"></i> By admin</li>
                                                    <li><i className="fa fa-tag"></i> electrical</li>
                                                </ul>
                                                <h4 className="title"><Link to="/news-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
                                            </div>
                                            <div className="bottom-box">
                                                <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                                <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                            </div>
                                        </div>
                                    </SwiperSlide>
                                    <SwiperSlide className="news-block wow fadeInUp">
                                        <div className="inner-box">
                                            <div className="image-box">
                                                <figure className="image">
                                                    <Link to="/news-details">
                                                        <img src={News3} alt=""/>
                                                    </Link>
                                                </figure>
                                                <span className="date"><b>12</b> OCT</span>
                                            </div>
                                            <div className="content-box">
                                                <ul className="post-info">
                                                    <li><i className="fa fa-user"></i> By admin</li>
                                                    <li><i className="fa fa-tag"></i> electrical</li>
                                                </ul>
                                                <h4 className="title"><Link to="/news-details">Powering Up: Innovations in Electrical Technology</Link></h4>
                                            </div>
                                            <div className="bottom-box">
                                                <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                                <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                            </div>
                                        </div>
                                    </SwiperSlide>
                                    <SwiperSlide className="news-block wow fadeInUp">
                                        <div className="inner-box">
                                            <div className="image-box">
                                                <figure className="image">
                                                    <Link to="/news-details">
                                                        <img src={News2} alt=""/>
                                                    </Link>
                                                </figure>
                                                <span className="date"><b>12</b> OCT</span>
                                            </div>
                                            <div className="content-box">
                                                <ul className="post-info">
                                                    <li><i className="fa fa-user"></i> By admin</li>
                                                    <li><i className="fa fa-tag"></i> electrical</li>
                                                </ul>
                                                <h4 className="title"><Link to="/news-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
                                            </div>
                                            <div className="bottom-box">
                                                <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                                <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                            </div>
                                        </div>
                                    </SwiperSlide>
                                </Swiper>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Blog;
