import React from 'react';
import { Link } from 'react-router-dom';
import TeamBgImg from '../../assets/images/background/25.jpg';
import TeamImg1 from '../../assets/images/resource/team1-1.jpg';
import TeamImg2 from '../../assets/images/resource/team1-2.jpg';
import TeamImg3 from '../../assets/images/resource/team1-3.jpg';
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
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to="/page-team-details"><img src={TeamImg1} alt="Image"/></Link></figure>
                        <div className="info-box">
                            <h4 className="name"><Link to="/page-team-details">John Mirkwood</Link></h4>
                            <span className="designation">Support Engineer</span> <span className="share-icon fa fa-share-alt"></span>
                            <div className="social-links">
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                            <Link to="#"><i className="fab fa-instagram"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            </div>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to="/page-team-details"><img src={TeamImg2} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="/page-team-details">Leslie Alexander</Link></h4>
                        <span className="designation">Support Engineer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                            <Link to="#"><i className="fab fa-instagram"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to="/page-team-details"><img src={TeamImg3} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="/page-team-details">Brooklyn Simmons</Link></h4>
                        <span className="designation">Support Engineer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                            <Link to="#"><i className="fab fa-instagram"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to="/page-team-details"><img src={TeamImg2} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="/page-team-details">Leslie Alexander</Link></h4>
                        <span className="designation">Support Engineer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                            <Link to="#"><i className="fab fa-instagram"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
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
