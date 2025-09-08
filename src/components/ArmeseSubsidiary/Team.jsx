import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
import TeamBgImg from '../../assets/images/background/25.jpg';
import TeamImg1 from '../../assets/images/armese/team/team1.jpg';
import TeamImg2 from '../../assets/images/armese/team/team2.jpg';
import TeamImg3 from '../../assets/images/armese/team/team3.jpg';
import TeamImg4 from '../../assets/images/armese/team/team4.jpg';
import TeamImg5 from '../../assets/images/armese/team/team5.jpg';
import TeamImg6 from '../../assets/images/armese/team/team6.jpg';
import TeamImg7 from '../../assets/images/armese/team/team7.jpg';
import { Swiper, SwiperSlide } from "swiper/react";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import 'swiper/css/pagination';

const imgPath = '/src/assets/images/armese/team/';


const swiperOptions = {
    modules: [Autoplay, Pagination, Navigation],
    slidesPerView: 3,
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

function Team({ className }) {
    const [isOpen, setOpen] = useState(false); 
        
        const ApiUrl = import.meta.env.VITE_API_URL;
        const [data, setData] = useState([]);
        const [loading, setLoading] = useState(true);
        const [error, setError] = useState(null);
        const [dataLoaded, setDataLoaded] = useState(false);
        
        useEffect(() => {
            const fetchData = async () => {
              try {
                const response = await fetch(ApiUrl + "armese/fetchManagementTeam");
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
    <section id="armeseTeam" className="team-section">
		<div className="bg bg-image" style={{ backgroundImage: `url(${TeamBgImg})`}}/>
		<div className="auto-container">
            <div className="sec-title text-center">
                <span className="sub-title">OUR EXPERTS</span>
                <h2>We Offer Cost Efficient <br />Electrician Team</h2>
            </div>
            <Swiper {...swiperOptions} className="team-carousel owl-theme"> 
      <div className="swiper-button-prev"><i className="fa fa-chevron-left"></i></div>
      <div className="swiper-button-next"><i className="fa fa-chevron-right"></i></div>

      {data.map(item => (
        <SwiperSlide key={item.armese_management_team_id} className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image">
                        
	<Popup
    trigger={<a><img src={imgPath + item.armese_management_team_pic} alt="Image"/></a>}
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
										<div className="team-details__top-img"> <img src={imgPath + item.armese_management_team_pic} alt="Image"/>
											<div className="team-details__big-text"></div>
										</div>
									</div>
								</div>
								<div className="col-xl-9 col-lg-9">
									<div className="team-details">
										<div className="team-details__top-content">
											<h4 className="team-details__top-name">{item.armese_management_team_name}</h4>
											<p className="team-details__top-title">{item.armese_management_team_designation}</p>
											<p className="page-content team"><div dangerouslySetInnerHTML={{ __html: item.armese_management_team_content }} />
	  </p>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Email Address</h5>
												<div className=""><span>{item.armese_management_team_email ?? "N/A"}</span></div>
											</div>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Phone Number</h5>
												<div className=""><span>{item.armese_management_team_phone ?? "N/A"}</span></div>
											</div>
											<div className="team-details__social"> <Link to={item.armese_management_team_linkedin == "" ? "#" : item.armese_management_team_linkedin}><i className="fab fa-linkedin"></i></Link><Link to={item.armese_management_team_facebook == "" ? "#" : item.armese_management_team_facebook}><i className="fab fa-facebook"></i></Link><Link to={item.armese_management_team_twitter == "" ? "#" : item.armese_management_team_twitter}><i className="fab fa-twitter"></i></Link></div>
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
                        <div className="info-box">
                            <h4 className="name"><a>{item.armese_management_team_name}
                            </a></h4>
                            <span className="designation">{item.armese_management_team_designation}
                            </span> <span className="share-icon fa fa-share-alt"></span>
                            <div className="social-links">
                            <Link to={item.armese_management_team_linkedin == "" ? "#" : item.armese_management_team_linkedin}><i className="fab fa-linkedin"></i></Link>
                            <Link to={item.armese_management_team_facebook == "" ? "#" : item.armese_management_team_facebook}><i className="fab fa-facebook-f"></i></Link>
                            <Link to={item.armese_management_team_twitter == "" ? "#" : item.armese_management_team_twitter}><i className="fab fa-twitter"></i></Link>
                            </div>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>

        ))}

{/*
                <SwiperSlide className="team-block">
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
											<h4 className="team-details__top-name">General Alexander Ogomudia (Rtd.)</h4>
											<p className="team-details__top-title">Chairman</p>
											<p className="page-content team">General Alexander Odeareduo Ogomudia (Rtd) CFR DSS FWC PSC(+) MSc FNSE is a retired Nigerian Military officer who served as Chief of Defence Staff and Chief of Army Staff.
	  <br/><br/>
	  General Ogomudia attended a number of military and civil courses at home and abroad. He attended Signal Officers Basic Course (SOBC 19) USA, Signals Officers' Degree Engineer Course (India), Diploma Electrical Electronics Engineering, Obafemi Awolowo University Ile-Ife, Battalion Commanders' Course Jaji, National War College Course Lagos and University of Ibadan amongst others.
	  <br/><br/>
	  He was appointed Chief of Army Staff in 2001 and served as Chief of Defence Staff of Nigeria from 2003 to 2006.
	  <br/><br/>
	  He joined the Nigerian Defence Academy (NDA) as a cadet in 1969 and is of NDA 7th Regular Course. He was commissioned in 1972 into the Nigerian Military Signal as Second Lieutenant with effect from October 1969. He grew through the ranks and held several senior military positions including; Directing Staff at Command and Staff College, Commander 53 Armoured Division Headquarters and Signal, Director of Telecommunications at Headquarters Nigerian Military Signals, Directing Staff, at National War College, Commandant Nigerian Military Signals and School and General Officer Commanding 1 Mechanized Division Nigerian Military.
	  <br/><br/>
	  He is married with children. His hobbies include Music, Farming and Engineering Design.
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
                        <div className="info-box">
                            <h4 className="name"><a>Dr. Emmanuel Audu-Ohwavborua
                            </a></h4>
                            <span className="designation">Executive Director Technical & Operations
                            </span> <span className="share-icon fa fa-share-alt"></span>
                            <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                            </div>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg2} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Emmanuel Emuejevoke Okotete
                        </Link></h4>
                        <span className="designation">Group Executive Director Commercial and Business Development</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg3} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Dr. Maurice Ibok
                        </Link></h4>
                        <span className="designation">Chief Executive Officer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg4} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Jean-Pierre Breton
                        </Link></h4>
                        <span className="designation">Chief Compliance Officer</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg5} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Gloria Alero Eigbobo (Mrs.)
                        </Link></h4>
                        <span className="designation">General Manager Legal/Human Resources</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg6} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Mr. Tolulope Ogunkolade
                        </Link></h4>
                        <span className="designation">General Manager, Metering Services Manufacturing Solutions Limited. </span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>
                <SwiperSlide className="team-block">
                    <div className="inner-box">
                        <div className="image-box">
                        <figure className="image"><Link to=""><img src={TeamImg7} alt="Image"/></Link></figure>
                        </div>
                        <div className="info-box">
                        <h4 className="name"><Link to="">Mrs. Uche V. Egwele
                        </Link></h4>
                        <span className="designation">Manager, Finance & Administration</span> <span className="share-icon fa fa-share-alt"></span>
                        <div className="social-links">
                            <Link to="#"><i className="fab fa-linkedin"></i></Link>
                            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                            <Link to="#"><i className="fab fa-twitter"></i></Link>
                        </div>
                        </div>
                    </div>
                </SwiperSlide>*/}
            </Swiper>
		</div>
	</section>
        )}
        </>
    );
}

export default Team;
