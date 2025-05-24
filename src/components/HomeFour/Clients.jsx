import React from 'react';
import { Link } from 'react-router-dom';
import ClientsImage1 from '../../assets/images/clients/1.png';
import ClientsImage2 from '../../assets/images/clients/2.png';
import ClientsImage3 from '../../assets/images/clients/3.png';
import ClientsImage4 from '../../assets/images/clients/4.png';
import ClientsImage5 from '../../assets/images/clients/5.png';
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
                    </Swiper>
                </div>
                </div>
            </section>
            {/* <!--End Clients Section --> */}
        </>
    );
}

export default Clients;
