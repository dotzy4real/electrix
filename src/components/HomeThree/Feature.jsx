import React from 'react';
import { Link } from 'react-router-dom';
import FeatureImage from '../../assets/images/resource/feature3-1.jpg';

function Process({ className }) {
    return (
        <>

	{/* <!-- Feature Section --> */}
	<section className="feature-section-three">
	  <div className="pattern-7 bounce-x"/>
	  <div className="shape-16"/>
	  <div className="auto-container">
	    <div className="row"> 
	      <div className="content-column col-lg-7">
	        <div className="inner-column">
	          <div className="sec-title light"> <span className="sub-title">CAPABILITIES</span>
	            <h2>Services that help our <br /> Customers meet</h2>
	          </div>
	          <div className="row"> 
	            <div className="feature-block-three col-lg-4 col-sm-6">
                <div className="inner-box"> <i className="icon flaticon-023-telephone-socket"></i>
                  <h5 className="title"><Link to="/page-about">Easy Payments</Link></h5>
                  <div className="text">Lorem ipsum dolor sit amet conse adipiscing</div>
                </div>
	            </div>
              <div className="feature-block-three col-lg-4 col-sm-6">
                <div className="inner-box"> <i className="icon flaticon-024-socket"></i>
                  <h5 className="title"><Link to="/page-about">Safe & Secure</Link></h5>
                  <div className="text">Lorem ipsum dolor sit amet conse adipiscing</div>
                </div>
              </div>
              <div className="feature-block-three col-lg-4 col-sm-6">
                <div className="inner-box"> <i className="icon flaticon-028-pcb-board"></i>
                  <h5 className="title"><Link to="/page-about">Global Services</Link></h5>
                  <div className="text">Lorem ipsum dolor sit amet conse adipiscing</div>
                </div>
              </div>
              <Link to="tel:+88(9800)6802" className="info-btn"> <i className="icon fa fa-phone"></i> <small>Call Anytime</small> <strong>+ 88 ( 9800 ) 6802</strong> </Link>
	          </div>
	        </div>
	      </div>
        <div className="image-column col-lg-5">
          <div className="inner-column">
            <div className="image-box">
              <figure className="image overlay-anim reveal"><img src={FeatureImage} alt="Image"/></figure>
            </div>
          </div>
        </div>
	    </div>
	  </div>
	</section>
	{/* <!-- End Feature Section --> */}
        </>
    );
}

export default Process;
