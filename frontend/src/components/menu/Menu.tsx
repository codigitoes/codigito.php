import React from 'react';
import { Link } from 'react-router-dom';
import './menu.scss';

interface MenuProps {
}

const Menu: React.FC<MenuProps> = ({ }) => {
    return (
        <>
            <div className='menu'>
                <div className="item">
                    <span className="title">Principal</span>
                    <Link className='listItem' to="/">
                        <img src="/home.svg" alt="" />
                        <span className='listItemTitle'>Home</span>
                    </Link>
                    <Link className='listItem' to="/blog">
                        <img src="/post2.svg" alt="" />
                        <span className='listItemTitle'>Blog</span>
                    </Link>
                </div>
                <div className="item">
                    <span className="title">Categorias</span>
                    <Link className='listItem' to="/">
                        <img src="/settings.svg" alt="" />
                        <span className='listItemTitle'>Perfil</span>
                    </Link>
                </div>
            </div >
        </>
    );
};

export default Menu;
