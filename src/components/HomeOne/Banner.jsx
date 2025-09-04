import { Link } from 'react-router-dom';
import React, { useEffect, useState } from 'react';
import BannerImage1 from '../../assets/images/resource/homebanners/homebanner1.jpeg';
import BannerImage2 from '../../assets/images/resource/homebanners/homebanner2.jpeg';
import BannerImage3 from '../../assets/images/resource/homebanners/homebanner3.jpeg';
import { decode } from 'html-entities';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

const BannerPath = '/src/assets/images/resource/homebanners';

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
    spaceBetween: 50,
    autoplay: {
        delay: 25000,
        disableOnInteraction: false,
    },
    loop: true,
    pagination: {
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};


 

function Banner({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/gethomebanners");
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
  }, []); // Empty dependency array means this effect runs once on mount

  if (error) {
    return (<div>Error: {error.message}</div>);
  }
    return (
        <>
        {  dataLoaded && (
            <section id='homeBanners' className={`banner-section ${className || ''}`}>
                <Swiper slidesPerView={'auto'} observer={true} observeParents={true} {...swiperOptions} className="banner-carousel owl-theme">
     
      {data.map(item => (
        
<SwiperSlide className="slide-item" key={item.homebanner_id}>
            <div className="bg-image" style={{ backgroundImage: `url(${BannerPath}/${item.homebanner_pic})`}}/>
            <div className="auto-container">
                <div className="content-box">
                    <span className="sub-title animate-1">{item.homebanner_subtitle}</span>
                    <h1 className="title animate-2"><div dangerouslySetInnerHTML={{ __html: item.homebanner_maintitle }} /></h1>
                    
                    <div className="btn-box animate-3">
                        <Link to={item.homebanner_button_link} className="theme-btn btn-style-one bg-light"><span className="btn-title">{item.homebanner_button_text}</span></Link>
                    </div>
                </div>
            </div>
            </SwiperSlide>
        ))}
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next">{/**/<i className="fa fa-chevron-right"></i>}</div>

{/* 

                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage1})`}}/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-1">Integrated Electromechanical Solutions</span>
                                <h1 className="title animate-2">From Concept To  <br />Commissioning</h1>
                                <div className="btn-box animate-3">
                                    <Link to="/what-we-do" className="theme-btn btn-style-one bg-light"><span className="btn-title">WHAT WE OFFER</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage2})`}}/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-1">Customized Electrical Engineering Solutions</span>
                                <h1 className="title animate-2">To Our Valued  <br />Customers</h1>
                                <div className="btn-box animate-3">
                                    <Link to="/contact" className="theme-btn btn-style-one bg-light"><span className="btn-title">CONTACT US NOW</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                    <SwiperSlide className="slide-item">
                        <div className="bg-image" style={{ backgroundImage: `url(${BannerImage3})`}}/>
                        <div className="auto-container">
                            <div className="content-box">
                                <span className="sub-title animate-1">We Bring Creativity To The Solutions We Develop</span>
                                <h1 className="title animate-2">Creativity In All  <br />We Do</h1>
                                <div className="btn-box animate-3">
                                    <Link to="/who-we-are" className="theme-btn btn-style-one bg-light"><span className="btn-title">LEARN MORE</span></Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>*/}
                </Swiper>
                {/*<!-- Add Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>*/}
            </section>)}
        </>
    );
}

export default Banner;
