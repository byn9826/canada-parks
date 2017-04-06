import React from 'react';
import ReactDOM from 'react-dom';
import reqwest from 'reqwest';

const Park = ({park, remove}) => {
    return (
        <tr>
            <td>{park.name}</td>
            <td>{park.province}</td>
            <td>
                <a className="btn btn-success" href={'form.php?action=edit&id=' + park.id}>Edit</a>
                <a className="btn btn-danger" onClick={() => {remove(park.id)}}>Delete</a>
            </td>
        </tr>
    );
};

const ParkList = ({parks, remove}) => {
    const parksNode = parks.map((park) => {
        return (<Park park={park} key={park.id} remove={remove} />);
    });
    return (
        <table className="table table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Province</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            {parksNode}
            </tbody>
        </table>
    );
};

class AdminParks extends React.Component {
    constructor(props) {
        super(props);
		this.state = {
            parks: this.props.parks,
            filters: [],
        };
	}
	componentWillMount(){
        this.setState({filters: this.state.parks});
    }
	handleRemove(id) {
	    console.log(id);
	    reqwest({
        	url: '/lib/park/ParkController.php',
        	method: "POST",
        	data: {id: id},
        	success: function(result) {
        	    var parks = JSON.parse(result);
        	    console.log(parks);
        	    this.state.parks = parks;
        	}
        }.bind(this));
	}
	filter(e) {
	    var filters = this.props.parks;
	   // filters = filters.filter(function(park) {
	   //     return park.name.toLowerCase().search(e.target.value.toLowerCase()) !== -1;
	   // });
	   // this.setState({filters: filters});
	}
    render() {
        return (
            <div>
                <input onChange={this.filter} />
                <ParkList parks={this.state.filters} remove={this.handleRemove.bind(this)} />
            </div>
        );
    }
}

reqwest({
    url: '/lib/park/ParkController.php',
    method: 'GET',
    success: function(result) {
        var parks = JSON.parse(result);
        ReactDOM.render(<AdminParks parks={parks} />, document.getElementById('admin-parks'));
    }
});