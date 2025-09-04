import React, { useEffect, useState } from 'react';
import CounterUp2 from '../../lib/CounterUp2.jsx'; 
import { Link } from 'react-router-dom';
import BannerBgImage from '../../assets/images/resource/homebanners/homebanner1.jpeg';
import BannerImage from '../../assets/images/main-slider/rotate-shine-1.png';
{/*import BannerImage1 from '../../assets/images/main-slider/img-5.png';*/}
import BannerImage1 from '../../assets/images/kilowatt/homebanners/homebanner1.jpeg';
import BannerImage2 from '../../assets/images/kilowatt/homebanners/homebanner2.jpeg';
import BannerImage3 from '../../assets/images/kilowatt/homebanners/homebanner3.jpeg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';
const BannerPath = '/src/assets/images/kilowatt/homebanners';

const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 1,
    spaceBetween: 30,
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
		const response = await fetch(ApiUrl + "kilowatt/gethomebanners");
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


	const percentage1 = 105;
    return (
        <>
		{  dataLoaded && (
	<section className={`banner-section-five ${className || ''}`}>
		<div className="bg-image5" style={{ backgroundImage: `url(${BannerBgImage})`}}/>
		<Swiper {...swiperOptions} className="banner-carousel owl-theme kilowatt">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>


      {data.map(item => (

		<SwiperSlide key={item.skyview_homebanner_id} className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">{item.kilowatt_homebanner_icontitle}</span>
								<h2 className="title animate-3"><div dangerouslySetInnerHTML={{ __html: item.kilowatt_homebanner_maintitle }} /></h2>
								<div className="text animate-4">{item.kilowatt_homebanner_subtitle}</div>
								<div className="btn-box animate-5">
									<Link to={item.kilowatt_homebanner_buttonlink} className="theme-btn btn-style-one bg-dark"><span className="btn-title">{item.kilowatt_homebanner_buttontext}</span></Link>
									{/*<figure className="image animate-5 animate-x"><img src={BannerImage} alt="Image"/>
									</figure>*/}
								</div>
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box">
								<div className="fact-counter-one">
									<h4 className="counter-title">TRUSTED BY</h4>
									<div className="count-box">
										<CounterUp2 count={percentage1} time={3} />
									</div>
								</div>
								<figure className="image animate-5 animate-x"><img src={BannerPath + "/" + item.kilowatt_homebanner_pic} alt="Image"/>
								</figure>
							</div>
						</div>
					</div>
				</div>
			</SwiperSlide>

))}

{/*
			<SwiperSlide className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">Utility Network Support</span>
								<h2 className="title animate-3">Faults<br />Identification</h2>
								<div className="text animate-4">Transformer refurbishment, maintenance, repairs and replacement, testing and commissioning of all sizes, up to 132kV.</div>
								<div className="btn-box animate-5">
									<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
								</div>
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box">
								<div className="fact-counter-one">
									<h4 className="counter-title">TRUSTED BY</h4>
									<div className="count-box">
										<CounterUp2 count={percentage1} time={3} />
									</div>
								</div>
								<figure className="image animate-5 animate-x"><img src={BannerImage3} alt="Image"/>
								</figure>
							</div>
						</div>
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">Systems Support</span>
								<h2 className="title animate-3">Rectification   <br className="d-none d-xl-block" />of faults.</h2>
								<div className="text animate-4">Troubleshooting, Refurbishment, Repair and Maintenance of Industrial Pumps, Drives, Valves, Motor Control Centres (MCC), Distributed Control Systems (DCS) and Electronic Control Systems.</div>
								<div className="btn-box animate-5">
									<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
									<figure className="image animate-5 animate-x"><img src={BannerImage} alt="Image"/>
									</figure>
								</div>
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box">
								<div className="fact-counter-one">
									<h4 className="counter-title">TRUSTED BY</h4>
									<div className="count-box">
										<CounterUp2 count={percentage1} time={3} />
									</div>
								</div>
								<figure className="image animate-5 animate-x"><img src={BannerImage2} alt="Image"/>
								</figure>
							</div>
						</div>
					</div>
				</div>
			</SwiperSlide>
			<SwiperSlide className="slide-item">
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12 col-sm-12">
							<div className="content-box">
								<span className="sub-title animate-2">Industrial Plants Construction</span>
								<h2 className="title animate-3">Electrical <br className="d-none d-xl-block" /> Rectification.</h2>
								<div className="text animate-4">Construction, Refurbishment, Repairs and Maintenance of Equipment Control Panels, switchgear, etc.</div>
								<div className="btn-box animate-5">
									<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
									<figure className="image animate-5 animate-x"><img src={BannerImage} alt="Image"/>
									</figure>
								</div>
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box">
								<div className="fact-counter-one">
									<h4 className="counter-title">TRUSTED BY</h4>
									<div className="count-box">
										<CounterUp2 count={percentage1} time={3} />
									</div>
								</div>
								<figure className="image animate-5 animate-x"><img src={BannerImage1} alt="Image"/>
								</figure>
							</div>
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
