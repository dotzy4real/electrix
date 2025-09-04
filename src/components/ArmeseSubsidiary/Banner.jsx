import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
{ /*//import BannerBgImage1 from '../../assets/images/main-slider/2.jpg'; */}
import BannerBgImage2 from '../../assets/images/main-slider/3.jpg';
import BannerBgImage1 from '../../assets/images/armese/homebanners/homebanner1.jpeg';
import BannerBgImage3 from '../../assets/images/armese/homebanners/homebanner2.jpeg';
import BannerBgImage4 from '../../assets/images/armese/homebanners/homebanner3.jpeg';
{/*import BannerBgImage1 from '../../assets/images/resource/homebanners/homebanner1.jpeg';
import BannerBgImage2 from '../../assets/images/resource/homebanners/homebanner2.jpeg';*/}
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';
const BannerPath = '/src/assets/images/armese/homebanners';

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
		const response = await fetch(ApiUrl + "armese/gethomebanners");
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
			<section className={`banner-section-two ${className || ''}`}>
				<Swiper {...swiperOptions} className="banner-carousel owl-theme">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next">{/**/}<i className="fa fa-chevron-right"></i></div>
	  
      {data.map(item => (
		<SwiperSlide key={item.armese_homebanner_id} className="slide-item">
		<div className="bg bg-image" style={{ backgroundImage: `url(${BannerPath}/${item.armese_homebanner_pic})`}}/>
		<div className="bg bg-image2" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
		<div className="shape-11 bounce-x"/>
		<div className="auto-container">
			<div className="content-box">
				<span className="sub-title animate-2">{item.armese_homebanner_subtitle}</span>
				<h1 className="title animate-3"><span><div dangerouslySetInnerHTML={{ __html: item.armese_homebanner_maintitle }} /></span></h1>
				<div className="btn-box animate-4">
					<Link to={item.armese_homebanner_buttonlink} className="theme-btn btn-style-one hvr-light"><span className="btn-title">{item.armese_homebanner_buttontext}</span></Link>
				</div>
			</div>
		</div>
	</SwiperSlide>
        ))}

		{/*
					<SwiperSlide className="slide-item">
						<div className="bg bg-image" style={{ backgroundImage: `url(${BannerBgImage1})`}}/>
						<div className="bg bg-image2" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
						<div className="shape-11 bounce-x"/>
						<div className="auto-container">
							<div className="content-box">
								<span className="sub-title animate-2">Power Sector Engineering/Advisory Services</span>
								<h1 className="title animate-3"><span>more than half a  
								<br />century experience</span></h1>
								<div className="btn-box animate-4">
									<Link to="/page-about" className="theme-btn btn-style-one hvr-light"><span className="btn-title">Learn more</span></Link>
								</div>
							</div>
						</div>
					</SwiperSlide>
					<SwiperSlide className="slide-item">
						<div className="bg bg-image" style={{ backgroundImage: `url(${BannerBgImage3})`}}/>
						<div className="bg bg-image2" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
						<div className="shape-11 bounce-x"/>
						<div className="shape-12 bounce-y"/>
						<div className="shape-13 bounce-y"/>
						<div className="auto-container">
							<div className="content-box">
								<span className="sub-title animate-2">Energy Efficiency & Energy Audit Services</span>
								<h1 className="title animate-3"><span>industrial and commercial <br />users of power</span></h1>
								<div className="btn-box animate-4">
									<Link to="/page-about" className="theme-btn btn-style-one hvr-light"><span className="btn-title">Book consultation</span></Link>
								</div>
							</div>
						</div>
					</SwiperSlide>
					<SwiperSlide className="slide-item">
						<div className="bg bg-image" style={{ backgroundImage: `url(${BannerBgImage4})`}}/>
						<div className="bg bg-image2" style={{ backgroundImage: `url(${BannerBgImage2})`}}/>
						<div className="shape-11 bounce-x"/>
						<div className="shape-12 bounce-y"/>
						<div className="shape-13 bounce-y"/>
						<div className="auto-container">
							<div className="content-box">
								<span className="sub-title animate-2">Revenue Assurance Services</span>
								<h1 className="title animate-3"><span>Hardware, Software,  <br />Boots on Ground</span></h1>
								<div className="btn-box animate-4">
									<Link to="/page-about" className="theme-btn btn-style-one hvr-light"><span className="btn-title">Contact us</span></Link>
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
