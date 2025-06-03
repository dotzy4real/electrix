import React from 'react';
import { Link } from 'react-router-dom';
import TeamBgImg from '../../assets/images/background/25.jpg';
import TeamImg1 from '../../assets/images/armese/team/team1.jpg';
import TeamImg2 from '../../assets/images/armese/team/team2.jpg';
import TeamImg3 from '../../assets/images/armese/team/team3.jpg';
import TeamImg4 from '../../assets/images/armese/team/team4.jpg';
import TeamImg5 from '../../assets/images/armese/team/team5.jpg';
import TeamImg6 from '../../assets/images/armese/team/team6.jpg';
import TeamImg7 from '../../assets/images/armese/team/team7.jpg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
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
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};

function Team({ className }) {
    return (
        <>
    <section className="team-section">
		<div className="bg bg-image" style={{ backgroundImage: `url(${TeamBgImg})`}}/>
		<div className="auto-container">
            <div className="sec-title text-center">
                <span className="sub-title">OUR EXPERTS</span>
                <h2>We Offer Cost Efficient <br />Electrician Team</h2>
            </div>
            <Swiper {...swiperOptions} className="team-carousel owl-theme"> 
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next">{/**/}<i className="fa fa-chevron-right"></i></div>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg1} alt="Image"/></Link></figure>
                        <div className="info-box">
                            <h4 className="name"><Link to="">Dr. Emmanuel Audu-Ohwavborua
                            </Link></h4>
                            <span className="designation">Executive Director Technical & Operations
                            </span> <span className="share-icon fa fa-share-alt"></span>
                            <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                            </div>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg2} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Emmanuel Emuejevoke Okotete
                        </Link></h4>
                        <span className="designation">Group Executive Director Commercial and Business Development</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg3} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Dr. Maurice Ibok
                        </Link></h4>
                        <span className="designation">Chief Executive Officer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg4} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Jean-Pierre Breton
                        </Link></h4>
                        <span className="designation">Chief Compliance Officer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg5} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Gloria Alero Eigbobo (Mrs.)
                        </Link></h4>
                        <span className="designation">General Manager Legal/Human Resources</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg6} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Mr. Tolulope Ogunkolade
                        </Link></h4>
                        <span className="designation">General Manager, Metering Services Manufacturing Solutions Limited. </span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg7} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Mrs. Uche V. Egwele
                        </Link></h4>
                        <span className="designation">Manager, Finance & Administration</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
            </Swiper>
		</div>
	</section>
        </>
    );
}

export default Team;
