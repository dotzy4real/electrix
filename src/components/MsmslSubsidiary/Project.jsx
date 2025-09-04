import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import ProjectBgImage from '../../assets/images/msmsl/project_back.jpg';
import ProjectImage1 from '../../assets/images/msmsl/facility/facility1.jpg';
import ProjectImage2 from '../../assets/images/msmsl/facility/facility2.jpg';
import ProjectImage3 from '../../assets/images/msmsl/facility/facility3.jpg';
import ProjectImage4 from '../../assets/images/msmsl/facility/facility4.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
const imgPath = '/src/assets/images/msmsl/facility/';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 4,
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
    }
};

function Project({ className }) {


    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [equipment, setEquipment] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "msmsl/getProjects");
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            setData(result);
          } catch (error) {
            setError(error);
          } finally {
            setLoading(false);
          }
        };
    
        fetchData();
      }, []);
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "msmsl/getEquipment");
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            setEquipment(result);
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
            <section className={`project-section-three ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ProjectBgImage})` }}/>
                <div className="auto-container armese-projects">
                    <div className="sec-title light">
                        <div className="row align-items-center">
                            <div className="col-lg-7">
                                <span className="sub-title">{equipment.msmsl_equipment_icon_title}</span>
                                <h2><div dangerouslySetInnerHTML={{ __html: equipment.msmsl_equipment_title }} /></h2>
                                {/*<h2>World Class <br />Equipments We Use</h2>*/}
                            </div>
                            <div className="col-lg-5">
                                <div className="text">
                                <div dangerouslySetInnerHTML={{ __html: equipment.msmsl_equipment_summary }} />
                                    {/*In line with our vision to incorporate cutting-edge technology into the core of our operations, our facility has state-of-the-art equipment such as below: */}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="carousel-outer">
                        <Swiper {...swiperOptions} className="projects-carousel-six owl-theme default-dots">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>



      {data.map(item => (
        
        <SwiperSlide key={item.msmsl_project_id} className="project-block">
        <div className="inner-box">
            <div className="image-box">
            <figure className="image"><a><img src={imgPath + item.msmsl_project_pic} alt="Image"/></a></figure>
            </div>
            <div className="content-box">
            <a className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></a><br />
            <h4 className="title"><a>{item.msmsl_project_title}</a></h4>
            <span className="cat">{item.msmsl_project_category_title}</span>
            </div>
            <div className="overlay-1"></div>
        </div>
        </SwiperSlide>

))}

{/*
                            <SwiperSlide className="project-block">
                            <div className="inner-box">
                                <div className="image-box">
                                <figure className="image"><a><img src={ProjectImage1} alt="Image"/></a></figure>
                                </div>
                                <div className="content-box">
                                <a className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></a><br />
                                <h4 className="title"><a>Testing Benches</a></h4>
                                <span className="cat">Metering Solution</span>
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
                                <h4 className="title"><Link to="/page-project-details">Plastic Injection Moulding Machine
                                </Link></h4>
                                <span className="cat">Metering Solution</span>
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
                                <h4 className="title"><Link to="/page-project-details">Energy Meter Voltage Withstand Equipment
                                </Link></h4>
                                <span className="cat">Metering Solution</span>
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
                                <h4 className="title"><Link to="/page-project-details">Programmable Dust Test Machine
                                </Link></h4>
                                <span className="cat">Metering Solution</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>*/}
                            {/*
                            <SwiperSlide className="project-block">
                            <div className="inner-box">
                                <div className="image-box">
                                <figure className="image"><Link to="/page-project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
                                </div>
                                <div className="content-box">
                                <Link to="/page-project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link to="/page-project-details">Wiring Solutions</Link></h4>
                                <span className="cat">Electrica Company</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>*/}
                        </Swiper>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Project;
