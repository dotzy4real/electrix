import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import Service1 from '../../assets/images/skyview/services/service1.jpg';
import Service2 from '../../assets/images/skyview/services/service2.jpg';
import Service3 from '../../assets/images/skyview/services/service3.jpg';
import Service4 from '../../assets/images/skyview/services/service4.jpg';
import ServiceBgImg from '../../assets/images/background/7.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
import ServiceDetailsImage from '../../assets/images/resource/services/engineering_procurement.jpg';
const imgPath = '/src/assets/images/skyview/';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 3,
    spaceBetween: 30,
    autoplay: {
        delay: 15000,
        disableOnInteraction: false,
    },
    pagination: {
        clickable: true,
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
		const response = await fetch(ApiUrl + "skyview/fetchServices");
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
    <section id="services" className={`services-section-two skyview ${className || ''}`}>
		<div className="bg bg-image" style={{ backgroundImage: `url(${ServiceBgImg})`}}/>
		<div className="auto-container skyview-services">
			<div className="sec-title skyview text-center">
				<span className="sub-title">WHAT WE DO</span>
				<h2 className="service-title">We Offer Cost Efficient <br />Electrical Services</h2>
			</div>
			<Swiper {...swiperOptions} className="services-carousel owl-theme default-dots">
                          <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
                          <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>
						  {data.map(item => (

<SwiperSlide key={item.skyview_service_id} className="service-block-two">
<div className="inner-box">
	<div className="image-box">
		<figure className="image"><Link to=""><img src={imgPath + "services/" + item.skyview_service_pic} alt="Image"/></Link></figure>
	</div>
	<div className="content-box">
		<div className="inner"> <i className="icon flaticon-024-socket"></i>
			<h4 className="title"><Link to="">{item.skyview_service_title}</Link></h4>
			<div className="text">{item.skyview_service_snippet}</div>
		</div>
		{/*<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>*/}
	</div>
</div>
</SwiperSlide>
							))}

{/*
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service1} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-049-wiring"></i>
								<h4 className="title"><Link to="/page-service-details">Project Construction</Link></h4>
								<div className="text">Project Construction Planning, Monitoring, Supervision, Evaluation and Commissioning.</div>
							</div>
							<Popup
    trigger={<a className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></a>}
    modal
  >
    {close => (
      <PopupBox title="Our Services - What We Do" content={<section className="services-details skyview csms_content">
		<div className="container">
			<div className="row">
				<div className="col-xl-12 col-lg-12">
					<div className="services-details__content">
						<img src={ServiceDetailsImage} alt="Image"/>
						<h3 className="mt-4">Project Construction</h3>
						<div>Income Electrix Limited (IEL) has over 30 years of experience in providing EPC Services in the African Power Sector. Our Expertise cuts across the following areas: 
							
<ul>
<li>EPC of Power Generation Projects up to 252MW.</li>

<li>EPC of Power Transmission Projects (132kV – 400kV).</li>

<li>EPC of Power Distribution Projects (0.415kV – 33kV).</li>

<li>EPC of Grid-Powered Streetlighting</li>

<li>EPC of Solar Powered Streetlighting</li>

<li>EPC of Other Renewable Energy Solutions</li>

<li>Engineering/Consulting Services</li>

<li>Specialized Procurement Services</li></ul>
</div>
						
						
					</div>
				</div>

			</div>
		</div>
	</section>} onClose={close} classProp='header skyview' classClose='close skyview' />
    )}
  </Popup>



						</div>
					</div>
				</SwiperSlide>
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service2} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-024-socket"></i>
								<h4 className="title"><Link to="/page-service-details">Electrification Projects</Link></h4>
								<div className="text">Design and supervision of rural/ urban electrification projects.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service3} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-001-light-bulb"></i>
								<h4 className="title"><Link to="/page-service-details">Power Projects</Link></h4>
								<div className="text">Environmental Impact Assessment Studies for large Power Projects.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>
				<SwiperSlide className="service-block-two">
					<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to="/page-service-details"><img src={Service4} alt="Image"/></Link></figure>
						</div>
						<div className="content-box">
							<div className="inner"> <i className="icon flaticon-049-wiring"></i>
								<h4 className="title"><Link to="/page-service-details">Engineering procurements</Link></h4>
								<div className="text">Feasibility and pre-feasibility studies for Engineering, Procurement and Construction projects.</div>
							</div>
							<Link to="/page-service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
						</div>
					</div>
				</SwiperSlide>*/}
			</Swiper>
		</div>
	</section>
        </>
    );
}

export default Service;
