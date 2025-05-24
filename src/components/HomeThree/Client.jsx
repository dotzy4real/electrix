import React from 'react';
import { Link } from 'react-router-dom';
import ClientBgImg from '../../assets/images/background/24.jpg';
import ClientImg1 from '../../assets/images/clients/6.png';
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

function Client({ className }) {
    return (
        <>
    <section className={`clients-section style-two ${className || ''}`}>
	    <div className="bg bg-image" style={{ backgroundImage: `url(${ClientBgImg})`}}/>
		<div className="auto-container"> 
		  <div className="sponsors-outer"> 
		     <Swiper {...swiperOptions} className="clients-carousel owl-theme disable-navs">
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
		    </Swiper>
		  </div>
		</div>
	</section>
        </>
    );
}

export default Client;
