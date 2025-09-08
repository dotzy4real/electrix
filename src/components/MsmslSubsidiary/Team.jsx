import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
{/*import TeamImg1 from '../../assets/images/resource/team2-1.jpg';
import TeamImg2 from '../../assets/images/resource/team2-2.jpg';
import TeamImg3 from '../../assets/images/resource/team2-3.jpg';
import TeamImg4 from '../../assets/images/resource/team2-4.jpg';*/}
import TeamImg1 from '../../assets/images/armese/team/team1.jpg';
import TeamImg2 from '../../assets/images/armese/team/team1.jpg';
import TeamImg3 from '../../assets/images/armese/team/team1.jpg';
import TeamImg4 from '../../assets/images/armese/team/team1.jpg';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Pagination, Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';

const imgPath = '/src/assets/images/msmsl/';


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
            slidesPerView: 2,
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

function Team({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);


  useEffect(() => {
      const fetchData = async () => {
        try {
          const response = await fetch(ApiUrl + "msmsl/fetchManagementTeam");
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
            <section id="MsmslTeam" className={`team-section-two msmsl ${className || ''}`}>
                <div className="shape-25 bounce-x"/>
                <div className="auto-container">
                    <div className="sec-title">
                        <div className="row">
                            <div className="col-lg-6 col-xl-7">
                                <span className="sub-title">OUR TEAMMATE</span>
                                <h2>Meet Our Latest <br />Teammate</h2>
                            </div>
                            <div className="col-lg-6 col-xl-5">
                                <div className="text">{/*Lorem ipsum dolor sit amet consectetur adipiscing elit velit convallis enim vestibulum sagittis sapien ac inceptos eget sociosqu volutpat integer sem curae nisl magnis montes eros et parturient.*/}</div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                    <Swiper {...swiperOptions} className="team-carousel owl-theme"> 
                                              <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
                                              <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>

                    
                        
                                              {data.map(item => (

                                                <SwiperSlide key={item.msmsl_management_team_id} className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image">{/*<Link to=""><img src={TeamImg1} alt="Image"/></Link>*/}
                                    <Popup
    trigger={<a><img src={TeamImg1} alt="Image"/></a>}
    modal
  >
    {close => (
      <PopupBox title="Management Team" content={<section className="team-details">
					<div className=""/>
					<div className="container pb-20">
						<div className="team-details__top pb-70">
							<div className="row">
								<div className="col-xl-3 col-lg-3">
									<div className="team-details__top-left">
										<div className="team-details__top-img"> <img src={imgPath + "team/" + item.msmsl_management_team_pic} alt="Image"/>
											<div className="team-details__big-text"></div>
										</div>
									</div>
								</div>
								<div className="col-xl-9 col-lg-9">
									<div className="team-details">
										<div className="team-details__top-content">
											<h4 className="team-details__top-name">{item.msmsl_management_team_name}</h4>
											<p className="team-details__top-title">{item.msmsl_management_team_designation}</p>
											<p className="page-content team">
                                            <div dangerouslySetInnerHTML={{ __html: item.msmsl_management_team_content }} />
                                                

	  </p>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Email Address</h5>
												<div className=""><span>{item.msmsl_management_team_email ?? "N/A"}</span></div>
											</div>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Phone Number</h5>
												<div className=""><span>{item.msmsl_management_team_phone ?? "N/A"}</span></div>
											</div>
											<div className="team-details__social"> <Link to={item.msmsl_management_team_linkedin}><i className="fab fa-linkedin"></i></Link><Link to={item.msmsl_management_team_facebook}><i className="fab fa-facebook"></i></Link><Link to={item.msmsl_management_team_twitter}><i className="fab fa-twitter"></i></Link></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>} onClose={close} classProp='header' classClose='close' />
    )}
  </Popup>
                                    </figure>
                                    <div className="social-links">
                                        <Link to={item.msmsl_management_team_linkedin}><i className="fab fa-linkedin"></i></Link>
                                        <Link to={item.msmsl_management_team_facebook}><i className="fab fa-facebook-f"></i></Link>
                                        <Link to={item.msmsl_management_team_twitter}><i className="fab fa-twitter"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><a>{item.msmsl_management_team_name}</a></h4>
                                    <span className="designation">{item.msmsl_management_team_designation}</span>
                                </div>
                            </div>
                        </SwiperSlide>


))}


{/*
                        <SwiperSlide className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image">
                                    <Popup
    trigger={<a><img src={TeamImg1} alt="Image"/></a>}
    modal
  >
    {close => (
      <PopupBox title="Management Team" content={<section className="team-details">
					<div className=""/>
					<div className="container pb-20">
						<div className="team-details__top pb-70">
							<div className="row">
								<div className="col-xl-3 col-lg-3">
									<div className="team-details__top-left">
										<div className="team-details__top-img"> <img src={TeamImg1} alt="Image"/>
											<div className="team-details__big-text"></div>
										</div>
									</div>
								</div>
								<div className="col-xl-9 col-lg-9">
									<div className="team-details">
										<div className="team-details__top-content">
											<h4 className="team-details__top-name">Tolu Ogunkolade</h4>
											<p className="team-details__top-title">General Manager</p>
											<p className="page-content team">Tolulope Ogunkolade is a seasoned and visionary Technology professional. 
<br/><br/>
He has over 15 years' experience spanning Power Generation from Diesel/Gas Generators, Supply Chain Management, World Class Manufacturing Operations, Quality Management Systems, Operational Excellence, CKD/SKD Technology, Lean Manufacturing, Six Sigma, TPM, Measurement Systems Analysis, APQQP/PPAP Engineering Operations Support Asset Reliability Strategy. 
<br/><br/>
He holds an MSc in Engineering Management from the Anglia Ruskin University and is a member of the Society of Corporate Governance of Nigeria and Nigeria Institute of Management Energy Management Association UK

	  </p>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Email Address</h5>
												<div className=""><span>info@incomeelectrix.com</span></div>
											</div>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Phone Number</h5>
												<div className=""><span>+012-3456-789</span></div>
											</div>
											<div className="team-details__social"> <Link to="#"><i className="fab fa-linkedin"></i></Link><Link to="#"><i className="fab fa-facebook"></i></Link><Link to="#"><i className="fab fa-twitter"></i></Link></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>} onClose={close} classProp='header' classClose='close' />
    )}
  </Popup>
                                    </figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><a>Tolu Ogunkolade</a></h4>
                                    <span className="designation">General Manager</span>
                                </div>
                            </div>
                        </SwiperSlide>
                        <SwiperSlide className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to=""><img src={TeamImg2} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="">Uche Egwele</Link></h4>
                                    <span className="designation">Finance/Admin Manager</span>
                                </div>
                            </div>
                        </SwiperSlide>
                        <SwiperSlide className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to=""><img src={TeamImg3} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="">Felix Ekanem</Link></h4>
                                    <span className="designation">Quality Inspection Engineer</span>
                                </div>
                            </div>
                        </SwiperSlide>
                        <SwiperSlide className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to=""><img src={TeamImg4} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="">Ndifreke Ntewo</Link></h4>
                                    <span className="designation">Test Engineer</span>
                                </div>
                            </div>
                        </SwiperSlide>*/}
                                                            </Swiper>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Team;
