import React from 'react';
import { Link } from 'react-router-dom';
import Service1 from '../../assets/images/resource/service3-1.jpg';
import Service2 from '../../assets/images/resource/service3-2.jpg';
import Service3 from '../../assets/images/resource/service3-3.jpg';
import Service4 from '../../assets/images/resource/service3-4.jpg';


function Service({ className }) {
    return (
        <>
			<section className={`services-section-three ${className || ''}`}>
				<div className="auto-container">
					<div className="outer-box">
						<div className="row">
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service1} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-011-hand-drill"></i>
									</div>
									<div className="content-box">
										<h4 className="title"><Link to="/page-service-details">Expert Services</Link></h4>
										<div className="text">Lorem ipsum dolor sit amet<br/> consectetur adipiscing elit<br/> posuere egesmetus</div>
									</div>
								</div>
							</div>
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service2} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-020-fuse-box"></i>
									</div>
									<div className="content-box">
										<h4 className="title"><Link to="/page-service-details">Expert Services</Link></h4>
										<div className="text">Lorem ipsum dolor sit amet<br/> consectetur adipiscing elit<br/> posuere egesmetus</div>
									</div>
								</div>
							</div>
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service3} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-017-wrench"></i>
									</div>
									<div className="content-box">
										<h4 className="title"><Link to="/page-service-details">Expert Services</Link></h4>
										<div className="text">Lorem ipsum dolor sit amet<br/> consectetur adipiscing elit<br/> posuere egesmetus</div>
									</div>
								</div>
							</div>
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service4} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-018-tester"></i>
									</div>
									<div className="content-box">
										<h4 className="title"><Link to="/page-service-details">Expert Services</Link></h4>
										<div className="text">Lorem ipsum dolor sit amet<br/> consectetur adipiscing elit<br/> posuere egesmetus</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
        </>
    );
}

export default Service;
