import React from 'react';
import BackToTop from '../BackToTop.jsx';
import Footer from './Footer.jsx';
import Banner from './Banner.jsx';
import Clients from './Clients.jsx';
import Service from './Service.jsx';
import Header from './Header.jsx';
import About from './About.jsx';
import FunFact from './FunFact.jsx';
import Team from './Team.jsx';
import ChooseUs from './ChooseUs.jsx';
import ChooseUs2 from './ChooseUs2.jsx';
import Project from './Project.jsx';
import Contact2 from '../MsmslSubsidiary/Contact2.jsx';
import Faq from './Faq.jsx';
import Video from './Video.jsx';
import Contact from './Contact.jsx';
import Testimonial from './Testimonial.jsx';
import News from './News.jsx';
import Cta from './Cta.jsx';
import Cta2 from './Cta2.jsx';

function HomeFour() {

    return (
        <>
            <Header />
            <Banner />
            <Clients />
            {/*<Service />*/}
            <About />
            <Project />
            <ChooseUs2 />
            <Team />
            <Contact2 />
            {/*<Cta />
            <Video />
            <FunFact />
            <Faq />
            <Contact />
            <Testimonial />
            <News />
            <Cta2 />*/}
            <Footer />
            <BackToTop />
        </>
    );
}

export default HomeFour;
