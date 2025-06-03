import React from 'react';
import { Link } from 'react-router-dom';
import ClientsImage1 from '../../assets/images/msmsl/clients/client1.jpg';
import ClientsImage2 from '../../assets/images/msmsl/clients/client2.jpg';
import ClientsImage3 from '../../assets/images/msmsl/clients/client3.jpg';
import ClientsImage4 from '../../assets/images/msmsl/clients/client4.jpg';
import ClientsImage5 from '../../assets/images/msmsl/clients/client5.png';
import ClientsImage6 from '../../assets/images/msmsl/clients/client6.jpg';
import ClientsImage7 from '../../assets/images/msmsl/clients/client7.jpg';
import ClientsImage8 from '../../assets/images/msmsl/clients/client8.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';


const swiperOptions = {
    modules: [Autoplay, Pagination],
    slidesPerView: 8,
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
            slidesPerView: 4,
        },
        991: {
            slidesPerView: 5,
        },
        1199: {
            slidesPerView: 7,
        },
        1350: {
            slidesPerView: 8,
        },
    }
};

function Clients({ className }) {
    return (
        <>
            {/* <!-- Clients Section --> */}
            <section className={`clients-section style-four ${className || ''}`}>
                <div className="auto-container">
                <div className="sponsors-outer"> 
                    <Swiper {...swiperOptions} className="clients-carousel owl-theme disable-navs">
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage1} alt="Image"/> 
                                <img src={ClientsImage1} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage2} alt="Image"/> 
                                <img src={ClientsImage2} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage3} alt="Image"/> 
                                <img src={ClientsImage3} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage4} alt="Image"/> 
                                <img src={ClientsImage4} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage5} alt="Image"/> 
                                <img src={ClientsImage5} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage6} alt="Image"/> 
                                <img src={ClientsImage6} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage7} alt="Image"/> 
                                <img src={ClientsImage7} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                        <SwiperSlide className="client-block">
                            <Link to="#" className="image"> 
                                <img src={ClientsImage8} alt="Image"/> 
                                <img src={ClientsImage8} alt="Image"/> 
                            </Link> 
                        </SwiperSlide>
                    </Swiper>
                </div>
                </div>
            </section>
            {/* <!--End Clients Section --> */}
        </>
    );
}

export default Clients;
