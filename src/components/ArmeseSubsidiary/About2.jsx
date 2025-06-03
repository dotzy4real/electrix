import React from 'react';
import AboutBgImg1 from '../../assets/images/background/21.jpg';
import AboutBgImg2 from '../../assets/images/background/22.jpg';
import AboutImg1 from '../../assets/images/resource/about3-3.jpg';

function About({ className }) {
    return (
        <>
<section className={`about-section-three ${className || ''}`}>
    <div className="bg bg-image" style={{ backgroundImage: `url(${AboutBgImg1})` }}/>
    <div className="bg bg-image2" style={{ backgroundImage: `url(${AboutBgImg2})` }}/>
		<div className="auto-container">
			<div className="row">
				<div className="content-column col-lg-7 col-md-12 col-sm-12">
					<div className="inner-column">
						<div className="sec-title light">
							<span className="sub-title">ABOUT COMPANY</span> 
							<h2>Outstanding Residential & Commercial Services</h2>
							<div className="text">Lorem ipsum dolor sit amet, consectetur notted adipisicing elit sed do eiusmod <br />tempor incididunt ut labore et simply free text dolore magna ediet aliqua lonm <br />andhn tempor facilisis sag</div>
						</div>

						<div className="info-style-one">
							<div className="inner">
								<figure className="image mb-0 overlay-anim"><img src={AboutImg1} alt=""/></figure>
								<ul className="list-style-five">
									<li><i className="fa fa-check-square"></i> Lorem ipsum dolor sit amet consectetur adipiscing</li>
									<li><i className="fa fa-check-square"></i> Lorem ipsum dolor sit amet consectetur</li>
									<li><i className="fa fa-check-square"></i> Lorem ipsum amet consectetur adipiscing</li>
									<li><i className="fa fa-check-square"></i> Lorem ipsum  consectetur adipiscing</li>
								</ul>
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

export default About;
