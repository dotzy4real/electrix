import React from 'react';
import { Link } from 'react-router-dom';
import News1 from '../../assets/images/resource/blog1-1.jpg';
import News2 from '../../assets/images/resource/blog1-2.jpg';
import News3 from '../../assets/images/resource/blog1-3.jpg';
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

function Blog({ className }) {
    return (
        <>
            <section id="news" className={`news-section ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center">
                    <span className="sub-title">OUR BLOG</span>
                    <h2 className="words-slide-up text-split">Check Latest Blog Post <br />from Blog List</h2>
                    </div>
                    <div className="carousel-outer">
                        <Swiper {...swiperOptions} className="testimonial-carousel owl-theme">
                            <SwiperSlide className="blog-block">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image">
                                            <Link to="/news-details">
                                                <img src={News1} alt="Image"/>
                                                <img src={News1} alt="Image"/>
                                            </Link>
                                        </figure>
                                    </div>
                                    <div className="content-box">
                                            <ul className="post-meta">
                                                <li className="categories"><Link to="/news-details">FURNITURE</Link></li>
                                                <li className="date">May 25, 2024</li>
                                            </ul>
                                            <h4 className="title"><Link to="/news-details">Smart Home Wiring A Guide for Modern Electricians</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="blog-block">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image">
                                            <Link to="/news-details">
                                                <img src={News2} alt="Image"/>
                                                <img src={News2} alt="Image"/>
                                            </Link>
                                        </figure>
                                    </div>
                                    <div className="content-box">
                                            <ul className="post-meta">
                                                <li className="categories"><Link to="/news-details">FURNITURE</Link></li>
                                                <li className="date">May 25, 2024</li>
                                            </ul>
                                            <h4 className="title"><Link to="/news-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="blog-block">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image">
                                            <Link to="/news-details">
                                                <img src={News3} alt="Image"/>
                                                <img src={News3} alt="Image"/>
                                            </Link>
                                        </figure>
                                    </div>
                                    <div className="content-box">
                                            <ul className="post-meta">
                                                <li className="categories"><Link to="/news-details">FURNITURE</Link></li>
                                                <li className="date">May 25, 2024</li>
                                            </ul>
                                            <h4 className="title"><Link to="/news-details">Powering Up Innovations in Electrical Technology</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="blog-block">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image">
                                            <Link to="/news-details">
                                                <img src={News2} alt="Image"/>
                                                <img src={News2} alt="Image"/>
                                            </Link>
                                        </figure>
                                    </div>
                                    <div className="content-box">
                                            <ul className="post-meta">
                                                <li className="categories"><Link to="/news-details">FURNITURE</Link></li>
                                                <li className="date">May 25, 2024</li>
                                            </ul>
                                        <h4 className="title"><Link to="/news-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                        </Swiper>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Blog;
