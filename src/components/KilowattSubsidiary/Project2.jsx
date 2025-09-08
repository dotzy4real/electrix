import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import ProjectBgImage from '../../assets/images/kilowatt/projects/project_back.jpg';
import ProjectImage1 from '../../assets/images/kilowatt/projects/project1.jpg';
import ProjectImage2 from '../../assets/images/kilowatt/projects/project2.jpg';
import ProjectImage3 from '../../assets/images/kilowatt/projects/project3.jpg';
import ProjectImage4 from '../../assets/images/kilowatt/projects/project4.jpg';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
import projectDetailImage from '../../assets/images/resource/projects/project-details/254-mw-gas.jpg';
const imgPath = '/src/assets/images/kilowatt/';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 4,
    spaceBetween: 30,
    autoplay: {
        delay: 50000,
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
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [equipment, setBenefit] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);


  useEffect(() => {
      const fetchData = async () => {
        try {
          const response = await fetch(ApiUrl + "kilowatt/getBenefits");
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const result = await response.json();
          setBenefit(result);
        } catch (error) {
          setError(error);
        } finally {
          setLoading(false);
          setDataLoaded(true);
        }
      };
  
      fetchData();
    }, []);


    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "kilowatt/getProjects");
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
/*
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "kilowatt/getProjects");
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
  }, []);*/
    
    return (
        <>
        {  dataLoaded && (
            <section id="kilowattProject" className={`project-section-three kilowatt ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ProjectBgImage})` }}/>
                <div className="auto-container kilowatt-projects">
                    <div className="sec-title light">
                        <div className="row align-items-center">
                            <div className="col-lg-7">
                                <span className="sub-title">OUR BENIFITIES</span>
                                <h2><div dangerouslySetInnerHTML={{ __html: equipment.kilowatt_benefit_title }} /></h2>
                            </div>
                            <div className="col-lg-5">
                                <div className="text">
                                <div dangerouslySetInnerHTML={{ __html: equipment.kilowatt_benefit_summary }} />
                                    {/*We have been awarded big projects from credible clients and we have also delivered these projects well above their expectations.*/}</div>
                            </div>
                        </div>
                    </div>
                    <div className="carousel-outer">

                        <Swiper {...swiperOptions} className="projects-carousel-six owl-theme default-dots">
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>
            
            
						{data.map(item => (
      <SwiperSlide key={item.kilowatt_project_id} className="project-block">
                            <div className="inner-box">
                                <div className="image-box">
                                <figure className="image"><Link><img src={imgPath + "projects/" + item.kilowatt_project_pic} alt="Image"/></Link></figure>
                                </div>
                                <div className="content-box">
                                <Link className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
                                <h4 className="title"><Link>{item.kilowatt_project_title} </Link></h4>
                                <span className="cat">{item.kilowatt_service_category_title}</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>
))}


{/*

                            <SwiperSlide className="project-block">
                            <div className="inner-box">
                                <div className="image-box">
                                <figure className="image"><img src={ProjectImage1} alt="Image"/></figure>
                                </div>
                                <div className="content-box">
                                <a className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></a><br />
                                <h4 className="title">
                                <Popup
    trigger={<figure className="image"><a>Engineering, Procurement and Design of 1 Mega Watt solar off grid village electrification inica Company Akugbene</a></figure>}
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
    </section>} onClose={close} classProp='header kilowatt' classClose='close kilowatt' />
    )}
  </Popup>
                                
                                
                                </h4>
                                <span className="cat">Power System</span>
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
                                <h4 className="title"><Link to="/page-project-details">Consultant For Pre-Feasibility Studies, Justification And Co-ordination Studies For The Power System </Link></h4>
                                <span className="cat">Power System</span>
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
                                <h4 className="title"><Link to="/page-project-details">Maintenance and Rehabilitation of Energy –Efficient Solar Street lights in Niger Delta Region (Lot 3), Rivers state</Link></h4>
                                <span className="cat">Solar Light</span>
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
                                <h4 className="title"><Link to="/page-project-details">Emergency construction of 5.0M 11KV overhead line single circuit to evacuate power</Link></h4>
                                <span className="cat">Power System</span>
                                </div>
                                <div className="overlay-1"></div>
                            </div>
                            </SwiperSlide>*/}
                        </Swiper>
                    </div>
                </div>
            </section>)}
        </>
    );
}

export default Project;
