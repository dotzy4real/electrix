import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import Popup from 'reactjs-popup';
import AboutThumbImg from '../../assets/images/armese/emmanuel_audu.jpg';
import AboutSignImg from '../../assets/images/resource/sign-2.png';
import AboutImg1 from '../../assets/images/armese/about1.jpg';
import AboutImg2 from '../../assets/images/armese/about2.jpg';
import PopupBox from '../PopupBox.jsx';
const imgPath = '/src/assets/images/armese/';



function About({ className }) {
	const [isOpen, setOpen] = useState(false); 

	const handleOpen = () => {
		setOpen(true);
	};
	
	const handleClose = () => {
		setOpen(false);
	};
	
	const ApiUrl = import.meta.env.VITE_API_URL;
	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [error, setError] = useState(null);
	const [dataLoaded, setDataLoaded] = useState(false);
	
	useEffect(() => {
		const fetchData = async () => {
		  try {
			const response = await fetch(ApiUrl + "armese/getHomeAbout");
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
		
    <section id='armeseAbout' className={`about-section-four armese ${className || ''}`}>
		<div className="auto-container">
			<div className="row">
				<div className="content-column col-xl-7 col-md-12 col-sm-12 order-lg-2 wow fadeInRight" data-wow-delay="600ms">
					<div className="inner-column">
						<div className="sec-title">
							<span className="sub-title">{data.armese_about_title_icon}</span>
							<h2>{data.armese_about_title}</h2>
							<div className="text aboutContent">
							<div dangerouslySetInnerHTML={{ __html: data.armese_about_home_content }} />
							
								{/*We specialize in conceptualization; power system engineering consulting and strategy; Transaction advisory services for IPPs, DISCOS, and prospective Power Sector Investors; technical audits/techno-economics, tendering/bid support and guideline preparation; and execution of special engineering projects.
						<ul>
							<li>Half a century of focused power experience.</li>
							<li>Full Spectrum of Services.</li>
							<li>Sustainable solutions to drive development and economic growth.</li>
							<li>Proven, senior-level expertise</li>
						</ul>*/}
							</div>
						</div>


						<div className="btn-box">
							<div className="founder-info">
								<div className="thumb"><img src={imgPath + "team/" + data.armese_management_team_pic} alt="Image"/></div>
								<div className="info">
									<h5 className="name">{data.armese_management_team_name}</h5>
									<span className="designation">{data.armese_management_team_designation}</span>
								</div>
							</div>
							{/*
							<a onClick={handleOpen} className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></a>
							
							<Popup  isOpen={open} onClose={handleClose} position="right center">
      <div>
        Popup Content Here!
      </div>
    </Popup>

	<Popup trigger={<a className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></a>} modal nested position="top">
      <div className="modal">
		
        Popup Content Here!
      </div>
    </Popup>*/}<Popup
		trigger={<a className="theme-btn btn-style-one bg-dark"><span className="btn-title">Learn More</span></a>}
		modal
	  >
		{close => (
		  <PopupBox title={data.armese_about_title} content={<div className="aboutContent">
			<div dangerouslySetInnerHTML={{ __html: data.armese_about_full_content }} />
			{/*Armese Consulting Limited specializes in conceptualization; power system engineering consulting and strategy; Transaction advisory services for IPPs, DISCOS, and prospective Power Sector Investors; technical audits/techno-economics, tendering/bid support and guideline preparation; and execution of special engineering projects.
<br/><br/>
			Electricity is the singular focus of Armese's professional practice. This single-sector approach has allowed us to grow quickly, attracting top professionals who know that their  experience and expertise will be highly valued and their efforts will be rewarded.
			<br/><br/>
			
			<b>Half a century of focused power experience</b> <br/>
			Armese Consulting brings more than half a century of combined senior experience in the power sector to the African market. 
			<br/><br/>
			<b>Full Spectrum of Services</b><br/>
			Armese Consulting delivers expertise in power generation, transmission, distribution and retail activities, as well as working with industrial and commercial end-users of power to maximize efficiencies and minimize costs.
			<br/><br/>
			<b>Sustainable solutions to drive development and economic growth</b> <br/>
			Armese Consulting can sustainably provide a full range of expertise in power generation, transmission, distribution and utility retail operations. The firm develops solutions that support African economies by ensuring reliable supplies of energy for consumers, businesses and industries. We are the first ever premium Metering Solutions Services provider aiming to continuously satisfy our valuable customers. We provide end-to -end metering solutions starting from the manufacture of premium quality meters, to tamper-proof installation, and continuous meter monitoring to guarantee revenue protection through optimized intelligent systems and efficient power utilization schemes, thus providing value to all stakeholders.
			<br/><br/>
			<b>Proven, senior-level expertise</b><br/>
			Armese Consulting has proven experts in every aspect of the power sector, with a track record of success in an ever-broadening range of projects that are helping to define the energy future of our clients.*/}
			<br/><br/></div>
			} onClose={close} classProp='header' classClose='close' />
		)}
	  </Popup>

{/*
	<Popup
    trigger={<a className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></a>}
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
										<div className="team-details__top-img"> <img src={AboutThumbImg} alt="Image"/>
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
				</section>} />
    )}
  </Popup>*/}
							{/*<a onClick={() => setOpen(true)} className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></a>*/}
							{/*<div className="signature-box"><img src={AboutSignImg} alt="Image"/></div>
							<Modal contentLabel="About Us" isOpen={isOpen} onClose={() => setOpen(false)} />*/}
						</div>
					</div>
				</div>
				<div className="image-column col-xl-5">
					<div className="inner-column wow fadeInLeft">
						<figure className="image-1 overlay-anim wow fadeInUp"><img src={imgPath + data.armese_about_left_pic} alt=""/></figure>
						<figure className="image-2 overlay-anim wow fadeInRight"><img src={imgPath + data.armese_about_right_pic} alt=""/></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
        </>
    );
}

export default About;
