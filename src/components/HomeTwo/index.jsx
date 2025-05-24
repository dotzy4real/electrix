import React from 'react';
import BackToTop from '../BackToTop.jsx';
import Footer from './Footer.jsx';
import Banner from './Banner.jsx';
import Service from './Service.jsx';
import Video from './Video.jsx';
import Header from './Header.jsx';
import About from './About.jsx';
import FunFact from './FunFact.jsx';
import Process from './Process.jsx';
import ChooseUs from './ChooseUs.jsx';
import Video2 from './Video2.jsx';
import Project from './Project.jsx';
import Faq from './Faq.jsx';
import Testimonial from './Testimonial.jsx';
import News from './News.jsx';
function HomeTwo() {

    return (
        <>
            <Header />
            <Banner />
            <About />
            <Service />           
            <Video />   
            <ChooseUs />
            <Video2 />  
            <Process /> 
            <Project />
            <FunFact />
            <Faq />
            <Testimonial />
            <News />
            <Footer />
            <BackToTop />
        </>
    );
}

export default HomeTwo;
