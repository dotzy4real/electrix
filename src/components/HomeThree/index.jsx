import React from 'react';
import BackToTop from '../BackToTop.jsx';
import Footer from './Footer.jsx';
import Banner from './Banner.jsx';
import Service from './Service.jsx';
import Team from './Team.jsx';
import Header from './Header.jsx';
import About from './About.jsx';
import About2 from './About2.jsx';
import FunFact from './FunFact.jsx';
import Feature from './Feature.jsx';
import Video from './Video.jsx';
import Client from './Client.jsx';
import Project from './Project.jsx';
import Faq from './Faq.jsx';
import Testimonial from './Testimonial.jsx';
import Contact from './Contact.jsx';
import News from './News.jsx';
import Cta from './Cta.jsx';
function HomeThree() {

    return (
        <>
            <Header />
            <Banner />
            <Service />  
            <About />  
            <About2 />  
            <Project />
            <Client /> 
            <Faq />
            <Team />  
            <Video />
            <FunFact />
            <Feature /> 
            <Testimonial />
            <Contact />
            <News />
            <Cta />
            <Footer />
            <BackToTop />
        </>
    );
}

export default HomeThree;
