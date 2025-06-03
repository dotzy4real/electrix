import React from 'react';
import { Link } from 'react-router-dom';
import ClientBgImg from '../../assets/images/background/24.jpg';
import ClientImg1 from '../../assets/images/armese/clients/client1.jpg';
import ClientImg2 from '../../assets/images/armese/clients/client2.jpg';
import ClientImg3 from '../../assets/images/armese/clients/client3.jpg';
import ClientImg4 from '../../assets/images/armese/clients/client4.jpg';
import ClientImg5 from '../../assets/images/armese/clients/client5.png';
import ClientImg6 from '../../assets/images/armese/clients/client6.jpg';
import ClientImg7 from '../../assets/images/armese/clients/client7.jpg';
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
    <section className={`clients-section feature-section-three style-two ${className || ''}`}>
	    <div className="bg bg-image" style={{ backgroundImage: `url(${ClientBgImg})`}}/>
		<div className="auto-container"> 
		  <div className="sponsors-outer"> 
	          <div className="sec-title light"> {/*<h3><span className="sub-title">Our Clients and Partners</span></h3>*/}
              <h3>OUR CLIENTS AND PARTNERS</h3>
	          </div>
		     <Swiper {...swiperOptions} className="clients-carousel owl-theme disable-navs">
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg1} alt="Image"/> 
                        <img src={ClientImg1} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg2} alt="Image"/> 
                        <img src={ClientImg2} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg3} alt="Image"/> 
                        <img src={ClientImg3} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg4} alt="Image"/> 
                        <img src={ClientImg4} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg5} alt="Image"/> 
                        <img src={ClientImg5} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg6} alt="Image"/> 
                        <img src={ClientImg6} alt="Image"/> 
                    </Link> 
                </SwiperSlide>
                <SwiperSlide className="client-block"> 
                    <Link to="#" className="image">
                        <img src={ClientImg7} alt="Image"/> 
                        <img src={ClientImg7} alt="Image"/> 
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
