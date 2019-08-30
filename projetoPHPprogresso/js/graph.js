google.charts.load('current', {
    packages: ['corechart', 'bar']
});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {


	// Bloco de variaveis para substituir na database
    var equipespontos = {
        lua: luapont,
        sol: solpont,
        vulcano: vulcanopont,
    };


    // Bloco da geração da tabela
    var data = google.visualization.arrayToDataTable([
        ['Time', 'Pontuação', {
            role: "style"
        }],
        ['Lua', equipespontos.lua, equipespontos.lua, ],
        ['Sol', equipespontos.sol, equipespontos.sol, ],
        ['Vulcano', equipespontos.vulcano, equipespontos.vulcano, ],
    ]);
    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2
    ]);
    var options = {
        title: 'Ranking das equipes',
        width: 1200,

        chartArea: {
            width: '70%'
        },
        hAxis: {
            title: 'Pontos',
            minValue: 0
        },
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

    chart.draw(view, options);
}
