import React, {Component} from "react";
import ReactDOM from "react-dom";
import reqwest from "reqwest";
class Search extends Component {
    constructor(props) {
        super(props);
		this.state = {
            content: "",
            result: [[], [], []],
            box: false,
            hover: false
        };
	}
    inputChange(e) {
        this.setState({content: e.target.value});
        let content = e.target.value.trim();
        let self = this;
        setTimeout(()=> {
            if (content == self.state.content.trim()) {
                reqwest({
                	url: self.props.route + "lib/search/handler.php",
                	method: "POST",
                	data: {"content": content},
                	success: function(result) {
                        let all = JSON.parse(result);
                        self.setState({result: all, box: true});
                    }
                });
            }
        }, 1000);
    }
    inputClose() {
        if (!this.state.hover) {
            this.setState({result: [[], [], []], box: false, content: ""});
        }
    }
    keepShow() {
        this.setState({hover: true});
    }
    leaveShow() {
        this.setState({hover: false});
    }
	render() {
        let matchParks = filterResult(this.state.result[0]);
        let matchStory = filterResult(this.state.result[1]);
        let parks, storys;
        if (matchParks.length > 0) {
            parks = matchParks.map((park, index) =>
                <div key={"search-park" + index} className="search-park-result">
                    <a href={this.props.route + "park/?id=" + park.id}>
                        <img src={park.banner} alt={park.name} />
                        <h6>{park.name}</h6>
                    </a>
                </div>
            );
        } else {
            parks = (
                <div className="search-park-result">
                    <h6>No parks found</h6>
                </div>
            );
        }
        if (matchStory.length > 0) {
            storys = matchStory.map((story, index) =>
                <div key={"search-story" + index} className="search-story-result">
                    <a href={this.props.route + "footprint/?uid=" + story.user_id + "&fid=" + story.footprint_id}>
                        <h6>{story.user_story.substring(0,50) + "..."}</h6>
                    </a>
                </div>
            );
        } else {
            storys = (
                <div className="search-park-result">
                    <h6>No footprints found</h6>
                </div>
            );
        }
        let search;
        if (this.state.box) {
            search = (
                <section id="search" onMouseOver={this.keepShow.bind(this)} onMouseOut={this.leaveShow.bind(this)}>
                    <div className="search-park">
                        <h5>Your might interested in parks:</h5>
                        {parks}
                    </div>
                    <div className="search-park">
                        <h5>Interesting footprints for you:</h5>
                        {storys}
                    </div>
                </section>
            );
        }
		return (
            <div className="form-group">
                <input type="text" className="form-control" placeholder="Search" value={this.state.content} onChange={this.inputChange.bind(this)} onBlur={this.inputClose.bind(this)} />
                {search}
            </div>
		);
	}
}

window.onload = function () {
    let route = document.getElementById("globe-team-route").innerHTML.trim();
    ReactDOM.render(<Search route={route} />, document.getElementById("search-root"));
}

function filterResult(result) {
    let nameIds = [], nameTimes = [], nameIndex = null;
    let nameResult = result;
    for (let i = 0; i < nameResult.length; i++) {
        if (nameIds.indexOf(nameResult[i]['id']) === -1) {
            nameIds.push(nameResult[i]['id']);
            nameTimes.push(1);
        } else {
            nameIndex = nameIds.indexOf(nameResult[i]['id']);
            nameTimes[nameIndex] += 1;
        }
    }
    let fTimes = Math.max.apply(Math, nameTimes);
    let fIndex = nameTimes.indexOf(fTimes);
    let newTimes = nameTimes.slice();
    let newIds = nameIds.slice();
    newTimes.splice(fIndex, 1);
    newIds.splice(fIndex, 1);
    let sTimes = Math.max.apply(Math, newTimes);
    let sIndex = newTimes.indexOf(sTimes);
    let fId = nameIds[fIndex];
    let sId = newIds[sIndex];
    let nameList = [];
    for (let i = 0; i < nameResult.length; i++) {
        if (nameResult[i]['id'] == fId) {
            nameList[0] = nameResult[i];
        } else if (nameResult[i]['id'] == sId) {
            nameList[1] = nameResult[i];
        }
    }
    return nameList;
}
