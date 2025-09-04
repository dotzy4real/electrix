import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import ProjectBgImage from '../../assets/images/background/33.jpg';
import ProjectImage1 from '../../assets/images/kilowatt/services/service1.jpg';
import ProjectImage2 from '../../assets/images/kilowatt/services/service2.jpg';
import ProjectImage3 from '../../assets/images/kilowatt/services/service3.jpg';
import ProjectImage4 from '../../assets/images/kilowatt/services/service4.jpg';
import ProjectImage5 from '../../assets/images/kilowatt/services/service5.jpg';
import ExpertImage1 from '../../assets/images/resource/expert1.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import "swiper/css/navigation";
const imgPath = '/src/assets/images/kilowatt/';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
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
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};


function Service({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "kilowatt/fetchServices");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        setData(result);
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setDataLoaded(true);
      }
    };

    fetchData();
  }, []);

    return (
        <>
        {  dataLoaded && (
            <section id="services" className={`project-section-five ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ProjectBgImage})`}}/>
                <div className="auto-container kilowatt-services">
                    <div className="sec-title text-center kilowatt servicekilowatt">
                        <span className="sub-title">OUR SERVICES</span>
                        <h2>We Deliver  Best <br />Electrical Services</h2>
                    </div>
                    <div className="carousel-outer">
                        <Swiper {...swiperOptions} className="projects-carousel-five owl-theme">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>

      {data.map(item => (
        <SwiperSlide key={item.kilowatt_service_id} className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={imgPath + "services/" + item.kilowatt_service_pic} className="lightbox-image"><img src={imgPath + "services/" + item.kilowatt_service_pic}  alt="Image"/></Link></figure>
                                        {/* <Link to="/page-project-details" className="icon"><i className="fa fa-long-arrow-alt-right"></i></Link> */}
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">{item.kilowatt_service_title}
                                        </span>
                                        <h4 className="title"><Link to={""}>{item.kilowatt_service_category_name}</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>

))}
{/*


                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage1} className="lightbox-image"><img src={ProjectImage1} alt="Image"/></Link></figure>
                                        
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Renewable Energy Research & Product Development
                                        </span>
                                        <h4 className="title"><Link to="/page-project-details">Energy</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage2} className="lightbox-image"><img src={ProjectImage2} alt="Image"/></Link></figure>
                                        
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Utility & Regulatory Support Services
                                        </span>
                                        <h4 className="title"><Link to="/page-project-details">Energy</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage3} className="lightbox-image"><img src={ProjectImage3} alt="Image"/></Link></figure>
                                        
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Power Distribution Infrastructure & Equipment  Maintenance
                                        </span>
                                        <h4 className="title"><Link to="/page-project-details">Electrical Support</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage4} className="lightbox-image"><img src={ProjectImage4} alt="Image"/></Link></figure>
                                        
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Power Source and Utilization  Optimization
                                        </span>
                                        <h4 className="title"><Link to="/page-project-details">Energy</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>
                            <SwiperSlide className="project-block-five">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to={ProjectImage5} className="lightbox-image"><img src={ProjectImage2} alt="Image"/></Link></figure>
                                        
                                    </div>
                                    <div className="content-box">
                                        <span className="cat">Energy Efficiency & Consultancy Services
                                        </span>
                                        <h4 className="title"><Link to="/page-project-details">Energy</Link></h4>
                                    </div>
                                </div>
                            </SwiperSlide>*/}
                        </Swiper>
                    </div>
                    {/*<div className="expert-info-box">
                        <div className="image-box">
                            <figure className="image"><img src={ExpertImage1} alt="Image"/></figure>
                            <i className="icon flaticon-037-capacitor"></i>
                        </div>
                        <div className="content-box">
                            <h4 className="expert-title">Simplify your Electrician</h4>
                            <div className="expert-text">A leader in electronics solutions since 2024</div>
                        </div>
                    </div>*/}
                </div>
            </section>)}
        </>
    );
}

export default Service;
