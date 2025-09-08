import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import ModalVideo from 'react-modal-video';
import BannerBgImage1 from '../../assets/images/skyview/homebanners/homebanner1.jpeg';
import BannerBgImage2 from '../../assets/images/skyview/homebanners/homebanner2.jpeg';
import BannerBgImage3 from '../../assets/images/skyview/homebanners/homebanner3.jpeg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';
const BannerPath = '/src/assets/images/skyview/homebanners';

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
    autoplay: {
        delay: 25000,
        disableOnInteraction: false,
    },
    loop: true,
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
		const response = await fetch(ApiUrl + "skyview/gethomebanners");
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



	  const [isOpen, setOpen] = useState(false);
    return (
        <>

{  dataLoaded && (
    <section className={`banner-section-three ${className || ''}`}>
        <Swiper {...swiperOptions} className="banner-carousel owl-theme skyview">
                    <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
                    <div className="swiper-button-next">{/**/}<i className="fa fa-chevron-right"></i></div>


                    {data.map(item => (
						<SwiperSlide key={item.skyview_homebanner_id} className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerPath + "/" + item.skyview_homebanner_pic})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">{item.skyview_homebanner_top_title}</span>
						<h1 className="title animate-3"><div dangerouslySetInnerHTML={{ __html: item.skyview_homebanner_main_title }} /></h1>
						<div className="btn-box animate-4">
							<Link to={item.skyview_homebanner_button_link} className="theme-btn btn-style-one hvr-light"><span className="btn-title">{item.skyview_homebanner_button_text}</span></Link>
						</div>
					</div>
				</div>
			</SwiperSlide>

))}

{/*
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">Ultra-modern company</span>
						<h1 className="title animate-3">Began operations in September 2017</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">We have the best team</span>
						<h1 className="title animate-3">Seasoned Professional <br/>Team at work</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="overlay-2"/>
				<div className="bg-image" style={{ backgroundImage: `url(${BannerBgImage3})`}}/>
				<div className="auto-container">
					<div className="content-box">
						<span className="sub-title animate-2">Seasoned Professionals</span>
						<h1 className="title animate-3">Exceptional Customer Services.</h1>
						<div className="btn-box animate-4">
							<Link to="/page-contact" className="theme-btn btn-style-one hvr-light"><span className="btn-title">CONTACT US NOW</span></Link>
						</div>
					</div>
				</div>
			</SwiperSlide>*/}
		</Swiper>
	</section>)}
        </>
    );
}

export default Banner;
