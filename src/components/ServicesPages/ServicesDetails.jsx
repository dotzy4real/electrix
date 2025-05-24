import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import AboutSide from '../AboutUs/AboutSide.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/services.jpeg';

import ServiceDetailsImage from '../../assets/images/resource/services/engineering_procurement.jpg';
import ServiceD1Image from '../../assets/images/resource/service-d1.jpg';
import ServiceD2Image from '../../assets/images/resource/service-d2.jpg';

function ServicesDetails() {
    const [showQues, setQues] = useState(1);
    const openQuestion = (value) => {
        setQues(value);
    };

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="What We Do"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/what-we-do', title: 'What We Do' },
                    { title: 'ENGINEERING, PROCUREMENT & CONSTRUCTION (EPC)' },
                ]}
				banner = {PageBanner}
            />
		    <section className="services-details">
				<div className="container">
					<div className="row">
						<div className="col-xl-8 col-lg-7 general-details-page">
							<div className="services-details__content">
								<img src={ServiceDetailsImage} alt="Image"/>
								<h3 className="mt-4">ENGINEERING, PROCUREMENT & CONSTRUCTION (EPC)</h3>
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

						<AboutSide />

						{/*
						<div className="col-xl-4 col-lg-5">
							<div className="service-sidebar">
								<div className="sidebar-widget service-sidebar-single">
									<div className="sidebar-service-list">
										<ul>
											<li><Link to="/what-we-do/service-details" className="current"><i className="fas fa-angle-right"></i><span>Wiring Solutions</span></Link></li>
											<li className="current"><Link to="/what-we-do/service-details"><i className="fas fa-angle-right"></i><span>Power Install</span></Link></li>
											<li><Link to="/what-we-do/service-details"><i className="fas fa-angle-right"></i><span>Circuit Repair</span></Link></li>
											<li><Link to="/what-we-do/service-details"><i className="fas fa-angle-right"></i><span>Panel Upgrade</span></Link></li>
											<li><Link to="/what-we-do/service-details"><i className="fas fa-angle-right"></i><span>Power Install</span></Link></li>
											<li><Link to="/what-we-do/service-details"><i className="fas fa-angle-right"></i><span>Generator Setup</span></Link></li>
										</ul>
									</div>
									<div className="service-details-help">
										<div className="help-shape-1"/>
										<div className="help-shape-2"/>
										<h2 className="help-title">Contact with <br/> us for any <br/> advice</h2>
										<div className="help-icon">
											<span className=" lnr-icon-phone-handset"></span>
										</div>
										<div className="help-contact">
											<p>Need help? Talk to an expert</p>
											<a className="text-white" href="tel:12463330079">+892 ( 123 ) 112 - 9999</a>
										</div>
									</div>
									<div className="sidebar-widget service-sidebar-single mt-4">
										<div className="service-sidebar-single-btn wow fadeInUp" data-wow-delay="0.5s" data-wow-duration="1200m">
											<Link to="#" className="theme-btn btn-style-two d-grid"><span className="btn-title"><span className="fas fa-file-pdf"></span> download pdf file</span></Link>
										</div>
									</div>
								</div>
							</div>
						</div>*/}



					</div>
				</div>
			</section>
            <Footer />
            <BackToTop />
        </>
    );
}

export default ServicesDetails;
