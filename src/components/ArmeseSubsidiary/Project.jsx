import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import ProjectImage1 from '../../assets/images/armese/projects/project1.jpg';
import ProjectImage2 from '../../assets/images/armese/projects/project2.jpg';
import ProjectImage3 from '../../assets/images/armese/projects/project3.jpg';
import ProjectImage4 from '../../assets/images/armese/projects/project4.jpg';
import ProjectImage5 from '../../assets/images/armese/projects/project5.jpg';
import ProjectImage6 from '../../assets/images/armese/projects/project6.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
import 'swiper/css';
import "swiper/css/navigation";
import 'swiper/css/pagination';
import projectDetailImage from '../../assets/images/resource/projects/project-details/254-mw-gas.jpg';

const imgPath = '/src/assets/images/armese/projects/';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
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
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};

function Project({ className }) {


const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "armese/getProjects");
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
    {  dataLoaded && <section id="armeseProject" className={`project-section style-three ${className || ''}`}>
		<div className="auto-container">
			<div className="sec-title">
				<span className="sub-title">RECENT PROJECTS</span>
				<h2>Checking  Our Electrical<br/> Portfolio for you.</h2>
			</div>
		</div>
		<div className="outer-box armese-projects">
            <Swiper {...swiperOptions} className="projects-carousel-three owl-theme">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>
                
                
      {data.map(item => (
                
                <SwiperSlide key={item.armese_project_id} className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <figure className="image"><img src={imgPath + item.armese_project_pic} alt="Image"/></figure>
                        </div>
                        <div className="content-box">
                            <Link className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title">{item.armese_project_title}</h4>
                            <span className="cat">{item.armese_project_category_title}</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>
        ))}
                {/*
                <SwiperSlide className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <Popup
    trigger={<figure className="image"><a><img src={ProjectImage1} alt="Image"/></a></figure>}
    modal
  >
    {close => (
      <PopupBox title="Our Projects" content={<section className="project-details">
        <div className="container">
            <div className="row">
                <div className="col-xl-12 col-lg-12 general-details-page">
                    <div className="sec-title">
                        <h3>EPC of 252 MW Gas Power Plant Construction at Omoku</h3>
                    </div>
                    <div className="project-details__top">
                        <div className="project-details__img"><img src={projectDetailImage} alt="Image"/></div>
                    </div>
                    <div className="row justify-content-center">
                        <div className="col-xl-12">
                            <div className="project-details__content-right">
                                <div className="project-details__details-box">
                                    <div className="row">
                                        <div className="col-lg-4">
                                            <p className="project-details__client">Date</p>
                                            <h4 className="project-details__name">10 January, 2025</h4>
                                        </div>
                                        <div className="col-lg-4">
                                            <p className="project-details__client">Client</p>
                                            <h4 className="project-details__name">Omoku Generation Company Limited</h4>
                                        </div>
                                        <div className="col-lg-4">
                                            <p className="project-details__client">Location</p>
                                            <h4 className="project-details__name">Omoku, Delta State, Nigeria</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="project-details__content">
                        <div className="row">
                            <div className="col-xl-12">
                                <div className="project-details__content-left">
                                    <h4 className="mb-4 mt-5">Details</h4>
                                    <div className="">Design, Engineering, Supply, Installation, Testing and Commissioning of 3 MVA (6x500KVA) Diesel Generating Power Plant at Obudu, Cross River State.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>} onClose={close} classProp='header' classClose='close' />
    )}
  </Popup>

                        </div>
                        <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title"><Link to="/page-project-details">Meter Assembly (Single Phase, Three Phase  & CIU)</Link></h4>
                            <span className="cat">Metering</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
                        </div>
                        <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title"><Link to="/page-project-details">Meter Assembly (Single Phase, Three Phase  & CIU)</Link></h4>
                            <span className="cat">Metering</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage3} alt="Image"/></Link></figure>
                        </div>
                        <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title"><Link to="/page-project-details">Meter Testing  And Aging Facility At MSMSL</Link></h4>
                            <span className="cat">Meter Testing</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage4} alt="Image"/></Link></figure>
                        </div>
                        <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title"><Link to="/page-project-details">Meter Testing  And Aging Facility At MSMSL</Link></h4>
                            <span className="cat">Meter Testing</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage5} alt="Image"/></Link></figure>
                        </div>
                        <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title"><Link to="/page-project-details">Sample Of Our Finished Products... Three Meter And Meter Box For Wall Mounting</Link></h4>
                            <span className="cat">Three Meter And Meter Box</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="project-block">
                    <div className="inner-box">
                        <div className="image-box">
                            <figure className="image"><Link to="/page-project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
                        </div>
                        <div className="content-box">
                            <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                            <h4 className="title"><Link to="/page-project-details">Sample Of Our Finished Products... Three Meter And Meter Box For Wall Mounting</Link></h4>
                            <span className="cat">Three Meter And Meter Box</span>
                        </div>
                        <div className="overlay-1"></div>
                    </div>
                </SwiperSlide>*/}
            </Swiper>
		</div>
	</section> }
        </>
    );
}

export default Project;
